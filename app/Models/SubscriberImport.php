<?php

namespace App\Models;

use App\Http\Requests\SubscriberRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SubscriberImport implements ToModel, WithValidation, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue
{
    use Importable;//, RemembersRowNumber;

    public function model(array $row)
    {        
        // $currentRowNumber = $this->getRowNumber();
        return new Subscriber([
            'name' => trim($row['name']),
            'passport' => trim($row['passport']),
            'national_id' => trim($row['national_id']),
            'work_permit' => trim($row['work_permit']),
            'contact' => 7654321,//trim($row['contact']),
            'country' => trim($row['country']),
            'company_id' => request()->get('company_id'),
            'plan_id' => request()->get('plan_id'),
            'begin_date' => '2021-01-01'
        ]);
    }  
    
    public function rules(): array
    {
        return [
            "name" => "required|alpha_space|min:5|max:255|unique:subscribers,name",
            "passport" => "required_without:national_id|min:5|max:20|alpha_num|unique:subscribers,passport",
            "national_id" => "required_without:passport|min:5|max:20|alpha_num|unique:subscribers,national_id,NULL,id,deleted_at,NULL",
            "work_permit" => "required_without:national_id|min:5|max:20|alpha_num|unique:subscribers,work_permit",
            "country" => "required|string|min:5|max:50|exists:countries,name",
            "contact" => "nullable|numeric|digits:7",
            "company_id" => "nullable|numeric|exists:companies,id",
            "plan_id" => "nullable|string|exists:plans,id",
            "begin_date" => "nullable|date"
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
