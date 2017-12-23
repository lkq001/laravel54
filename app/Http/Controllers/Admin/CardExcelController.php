<?php

namespace App\Http\Controllers\Admin;

use App\Model\CardExcel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Excel;

class CardExcelController extends Controller
{
    //

    public function index()
    {
        $cardExcel = CardExcel::paginate(10);

        return view('admin.cardExcel.index', [
            'cardExcel' => $cardExcel,
        ]);
    }

    /**
     * 下载模板
     *
     * author 李克勤
     */
    public function export()
    {
        $cellData = [
            ['kahao', 'mima', 'cishu'],
        ];
        Excel::create('cards', function ($excel) use ($cellData) {
            $excel->sheet('score', function ($sheet) use ($cellData) {
                $sheet->rows($cellData);
            });
        })->export('xls');
    }

    /**
     * 导入
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * author 李克勤
     */
    public function import(Request $request)
    {
        //  判断文件是否有上传
        if (!$request->hasFile('excel')) {
            $result = json_encode(['status' => 0, 'message' => '请上传文件']);
            return response()->json([
                'status' => '201',
                'message' => '请上传文件!'
            ]);
        }
        //  判断文件是否有效
        if (!$request->file('excel')->isValid()) {
            $result = json_encode(['status' => 0, 'message' => '请选择有效文件']);
            return response()->json([
                'status' => '201',
                'message' => '请选择有效文件!'
            ]);
        }
        // 判断文件格式是否正确
        $suffix = $request->file('excel')->getClientOriginalExtension();

        $arr = ['xls'];
        if (!in_array($suffix, $arr)) {
            $result = json_encode(['status' => 0, 'message' => '请上传xls格式文件']);
            return response()->json([
                'status' => '201',
                'message' => '请上传xls格式文件!'
            ]);
        }
        $file = $request->file('excel');
        $path = $file->move('./', 'cards.xls');

        $filePath = iconv('UTF-8', 'GBK', 'cards') . '.xls';

        Excel::load($filePath, function ($reader) {
            $data = $reader->get()->toArray();

            // 声明数组,用于储存数据
            $insertData = [];
            $arr = [];

            // 执行数据保存
            $cardExcel = new CardExcel();
            foreach ($data as $key => $value) {

                if (isset($value['卡号']) && isset($value['卡密']) && isset($value['次数'])) {
                    if (!$cardExcel->where('code', $value['卡号'])->count()) {
                        $insertData[$key]['code'] = preg_replace('# #', '', $value['卡号']);
                        $insertData[$key]['code_pw'] = $value['卡密'];
                        $insertData[$key]['number'] = $value['次数'];
                    } else {
                        $arr[] = $value['卡号'];
                    }
                }
            }

            $cardExcel->insert($insertData);
        });

        return redirect()->route('admin.card.excel.index');
    }
}
