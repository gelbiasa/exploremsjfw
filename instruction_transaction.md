# Instrukction Modifikasi Transaction Layout Manual 

# untuk acuan pengeditan views bisa melihat refrensi pada transc/auto (add, edit, list, show) 

1. dimana terdapat kode yang saya beri command {{-- Boleh diedit --}} yang berarti proses modifikasi file dilakukan disini 
2. dan untuk yang tidak saya beri command, jangan diedit karena itu adalah template kode dari framework ini

```blade
{{-- Area yang BOLEH diedit --}}
{{-- Content area, custom fields, additional JavaScript --}}

{{-- Area yang TIDAK BOLEH diedit --}} 
{{-- Framework template, base layout, routing logic --}}
```

# **Transaction Pattern Implementation**

##### A. **Standard CRUD Operations**
```php
// Setiap transaction controller memiliki:
public function index($data)     // List view
public function add($data)       // Add form view  
public function store($data)     // Store data with validation
public function show($data)      // Detail view
public function edit($data)      // Edit form view
public function update($data)    // Update data
public function destroy($data)   // Soft delete
```

##### B. **Transaction Validation Pattern**
```php
// Dynamic validation dari sys_table
$validate = [];
foreach ($data['table'] as $item) {
    if ($item['validate'] != '') {
        $validate[$item['field']] = $item['validate'];
    }
}

// Custom validation messages
$attributes = request()->validate($validate, [
    'required' => ':attribute tidak boleh kosong',
    'unique' => ':attribute sudah ada', 
    'min' => ':attribute minimal :min karakter',
    'max' => ':attribute maksimal :max karakter',
    'email' => 'format :attribute salah',
    'mimes' => ':attribute format harus :values'
]);
```

# 1. Transaction JUMBO (trbomj)

pada menu_trs_seeder saya sudah membuat sebuah menu dengan dmenu trbomj dengan nama Transaction BOM Jumbo dengan url trbomj

untuk controller silahkan edit sesuai dengan kebutuhan pada TrbomjController 

untuk views transaction Jumbo Ada Pada transc/trbomj
1. add.blade.php
2. edit.blade.php
3. list.blade.php
4. show.blade.php