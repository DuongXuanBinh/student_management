<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute phải được chấp nhận',
    'active_url' => ':attribute không phải URL có giá trị',
    'after' => ':attribute phải sau ngày :date.',
    'after_or_equal' => ':attribute phải bằng hoặc sau ngày :date.',
    'alpha' => ':attribute phải là chữ cái.',
    'alpha_dash' => ':attribute phải bao gồm chữ cái, số, dấu gạch ngang và gạch dưới',
    'alpha_num' => ':attribute  phải bao gồm chữ cái và số,',
    'array' => ':attribute phải là mảng dữ liệu',
    'before' => ':attribute phải trước ngày :date.',
    'before_or_equal' => ':attribute phải trước hoặc bằng ngày :date.',
    'between' => [
        'numeric' => ':attribute có giá trị giữa :min và :max.',
        'file' => ':attribute có giá trị giữa :min và :max kilobytes.',
        'string' => ':attribute có độ dài từ :min đến :max ký tự.',
        'array' => 'Mảng :attribute bao gồm từ :min đến :max phần tử.',
    ],
    'boolean' => ':attribute có giá trị đúng hoặc sai',
    'confirmed' => ':attribute không khớp.',
    'date' => ':attribute không phải ngày hợp lệ.',
    'date_equals' => ':attribute phải là ngày :date.',
    'date_format' => ':attribute không khớp định dạng :format.',
    'different' => ':attribute và :other phải khác nhau.',
    'digits' => ':attribute phải gồm :digits ký tự.',
    'digits_between' => ':attribute phải từ :min đến :max kí tự.',
    'dimensions' => ':attribute có kích thước không hợp lệ.',
    'distinct' => 'Trường :attribute bị lặp lại giá trị.',
    'email' => ':attribute phải là địa chỉ email hợp lệ',
    'ends_with' => ':attribute phải kết thúc với một trong những giá trị sau: :values.',
    'exists' => ':attribute được chọn không hợp lệ.',
    'file' => ':attribute phải là một tệp.',
    'filled' => 'Trường :attribute phải có giá trị.',
    'gt' => [
        'numeric' => ':attribute phải lớn hơn :value.',
        'file' => ':attribute phải lớn hơn :value kilobytes.',
        'string' => ':attribute phải lớn hơn :value ký tự.',
        'array' => ':attribute phải có nhiều hơn :value phần tử.',
    ],
    'gte' => [
        'numeric' => ':attribute phải lớn hơn hoặc bằng :value.',
        'file' => ':attribute phải lớn hơn hoặc bằng :value kilobytes.',
        'string' => ':attribute phải lớn hơn hoặc bằng :value characters.',
        'array' => ':attribute phải có từ :value phần tử trở lên',
    ],
    'image' => ':attribute phải là hình ảnh.',
    'in' => ':attribute đã chọn không hợp lệ.',
    'in_array' => 'Trường :attribute không có trong :other.',
    'integer' => ':attribute phải là số.',
    'ip' => ':attribute must be a valid IP address.',
    'ipv4' => ':attribute must be a valid IPv4 address.',
    'ipv6' => ':attribute must be a valid IPv6 address.',
    'json' => ':attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => ':attribute phải nhỏ hơn :value.',
        'file' => ':attribute phải nhỏ hơn :value kilobytes.',
        'string' => ':attribute phải ít hơn :value ký tự.',
        'array' => ':attribute phải ít hơn :value phần tử.',
    ],
    'lte' => [
        'numeric' => ':attribute phải nhỏ hơn hoặc bằng :value.',
        'file' => ':attribute phải nhỏ hơn hoặc bằng :value kilobytes.',
        'string' => ':attribute phải ít hơn hoặc bằng :value ký tự.',
        'array' => ':attribute phải nhỏ hơn hoặc bằng :value phần tử.',
    ],
    'max' => [
        'numeric' => ':attribute phải nhỏ hơn hoặc bằng :max.',
        'file' => ':attribute phải nhỏ hơn hoặc bằng :max kilobytes.',
        'string' => ':attribute phải ít hơn hoặc bằng :max phần tử.',
    ],
    'mimes' => ':attribute must be a file of type: :values.',
    'mimetypes' => ':attribute must be a file of type: :values.',
    'min' => [
        'numeric' => ':attribute phải lớn hơn hoặc bằng :min.',
        'file' => ':attribute phải lớn hơn hoặc bằng :min kilobytes.',
        'string' => ':attribute phải nhiều hơn hoặc bằng :min ký tự.',
        'array' => ':attribute phải nhiều hơn hoặc bằng :min phần tử.',
    ],
    'multiple_of' => ':attribute must be a multiple of :value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'Định dạng :attribute không hợp lệ.',
    'numeric' => ':attribute phải là số.',
    'password' => 'Mật khẩu không chính xác.',
    'present' => 'Trường :attribute phải tồn tại.',
    'regex' => 'Định dạng :attribute không hợp lệ.',
    'required' => ':attribute là trường bắt buộc',
    'required_if' => 'Trường :attribute bắt buộc khi :other có giá trị là :value.',
    'required_unless' => 'Trường :attribute bắt buộc trừ khi :other có giá trị là :values.',
    'required_with' => 'Trường :attribute bắt buộc khi :values tồn tại.',
    'required_with_all' => 'Trường :attribute bắt buộc khi :values tồn tại.',
    'required_without' => 'Trường :attribute bắt buộc khi :values không tồn tại.',
    'required_without_all' => 'Trường :attribute bắt buộc khi :values không tồn tại.',
    'prohibited' => ':attribute field is prohibited.',
    'prohibited_if' => ':attribute field is prohibited when :other is :value.',
    'prohibited_unless' => ':attribute field is prohibited unless :other is in :values.',
    'same' => ':attribute và :other không khớp.',
    'size' => [
        'numeric' => ':attribute phải có độ lớn là :size.',
        'file' => ':attribute phải có độ lớn là :size kilobytes.',
        'string' => ':attribute phải có :size ký tự.',
        'array' => ':attribute phải có :size phần tử.',
    ],
    'starts_with' => ':attribute phải bắt đầu bởi một trong các giá trị sau: :values.',
    'string' => ':attribute phải là chuỗi ký tự.',
    'timezone' => ':attribute phải là giá trị hợp lệ.',
    'unique' => ':attribute đã tồn tại.',
    'uploaded' => ':attribute tải lên thất bại.',
    'url' => 'Định dạng :attribute không hợp lệ.',
    'uuid' => ':attribute phải là UUID hợp lệ.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
