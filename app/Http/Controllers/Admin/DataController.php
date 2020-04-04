<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DataController extends Controller
{
    function __construct()
    {
        view()->share([
            '_data' => 'am-active'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.data.index');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
        // 从配置文件中获取数据库信息
        $DB_DATABASE = getenv('DB_DATABASE');
        $DB_USERNAME = getenv('DB_USERNAME');
        $DB_PASSWORD = getenv('DB_PASSWORD');

        // 定义导出后的SQL文件保存的位置
        $filepath = '/Users/holy/Desktop/' . $DB_DATABASE . "_" . date("Y-m-d_H-i-s") . ".sql";

        // 导出所有表结构和数据
        exec("mysqldump  -u" . $DB_USERNAME . " -p" . $DB_PASSWORD . " --default-character-set=utf8mb4 " . $DB_DATABASE . " -n > " . $filepath);
        return response()->json(['status' => 200, 'msg' => '导出成功']);
    }
}
