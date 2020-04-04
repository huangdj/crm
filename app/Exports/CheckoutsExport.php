<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class CheckoutsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $checkouts = \DB::table('checkouts')->leftJoin('users', 'users.id', '=', 'checkouts.user_id')
                    ->select('master_no', 'realname', 'users.base_salary as u_base_salary',
                             'users.percent as u_percent', 'checkouts.total_hours', 'checkouts.amount', 'checkouts.created_at')
                    ->get();
        return $checkouts;
    }

    /***
     * 导出时添加表头
     * @return array
     */
    public function headings(): array
    {
        return [
            '工号','姓名', '基础工资', '业务提成', '总课时费', '实发金额', '结算日期'
        ];
    }
}
