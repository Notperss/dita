<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'd_drive' => [
            'driver' => 'local',
            'root' => env('D_DRIVE_PATH', 'D:/laravel-storage'),
        ],

        'nas' => [
            'driver' => 'local',
            'root' => env('NAS_ROOT'),
            'visibility' => 'public',
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];

//SYMLINK

// If you’re working on Ubuntu (or any Linux distribution) and need to create a symbolic link for your Laravel storage directory, the process is quite straightforward compared to Windows. Here’s how to handle symbolic links and permissions on Ubuntu:

// ### Step 1: Create the Symlink

// 1. **Open Terminal**:
//    Open a terminal window.

// 2. **Create the Symlink**:
//    Use the `ln` command to create a symbolic link. The general syntax for creating a symlink is:

//    ```sh
//    ln -s /path/to/target /path/to/symlink
//    ```

//    For your Laravel application, you might want to create a symlink from the `public/storage` directory to a directory on your D drive. Assuming the target directory on your D drive is `/mnt/d/laravel-storage` and you want to link it to `/var/www/laravel/public/storage`, you would use:

//    ```sh
//    ln -s /mnt/d/laravel-storage /var/www/laravel/public/storage
//    ```

//    **Explanation**:
//    - `/mnt/d/laravel-storage` is the target directory where your files are stored.
//    - `/var/www/laravel/public/storage` is the symlink location where you want to access the files from your Laravel application.

// ### Step 2: Verify Permissions

// Ensure that the web server user (usually `www-data` for Apache or `nginx` for Nginx) has the appropriate permissions to read from and write to the target directory.

// 1. **Check Directory Permissions**:
//    ```sh
//    ls -ld /mnt/d/laravel-storage
//    ```

// 2. **Set Permissions**:
//    If necessary, adjust the permissions to ensure the web server can access the directory:

//    ```sh
//    sudo chown -R www-data:www-data /mnt/d/laravel-storage
//    sudo chmod -R 755 /mnt/d/laravel-storage
//    ```

//    **Explanation**:
//    - `chown` changes the ownership of the directory to the web server user.
//    - `chmod` sets the appropriate permissions.

// ### Step 3: Update `config/filesystems.php`

// Ensure your `config/filesystems.php` is configured to use the correct disk:

// ```php
// 'disks' => [
//     'd_drive' => [
//         'driver' => 'local',
//         'root' => '/mnt/d/laravel-storage',
//     ],
// ],
// ```

// ### Step 4: Test File Operations

// Use the Laravel Storage facade to manage files, similar to how it is done in Windows. Here’s a quick example:

// #### Controller (`app/Http/Controllers/FileController.php`):

// ```php
// <?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Storage;

// class FileController extends Controller
// {
//     public function upload(Request $request)
//     {
//         if ($request->hasFile('file')) {
//             $file = $request->file('file');
//             $path = $file->store('uploads', 'd_drive');
//             return response()->json(['path' => $path], 200);
//         }

//         return response()->json(['message' => 'No file uploaded'], 400);
//     }

//     public function download($filename)
//     {
//         $path = 'uploads/' . $filename;

//         if (Storage::disk('d_drive')->exists($path)) {
//             return response()->download(Storage::disk('d_drive')->path($path));
//         }

//         return response()->json(['message' => 'File not found'], 404);
//     }

//     public function delete($filename)
//     {
//         $path = 'uploads/' . $filename;

//         if (Storage::disk('d_drive')->exists($path)) {
//             Storage::disk('d_drive')->delete($path);
//             return response()->json(['message' => 'File deleted'], 200);
//         }

//         return response()->json(['message' => 'File not found'], 404);
//     }
// }
// ```

// #### Routes (`routes/web.php`):

// ```php
// use App\Http\Controllers\FileController;

// Route::post('/upload', [FileController::class, 'upload']);
// Route::get('/download/{filename}', [FileController::class, 'download']);
// Route::delete('/delete/{filename}', [FileController::class, 'delete']);
// ```

// #### Blade View (`resources/views/upload.blade.php`):

// ```blade
// <!DOCTYPE html>
// <html>
// <head>
//     <title>Upload File</title>
// </head>
// <body>
//     <h1>Upload File</h1>
//     <form action="/upload" method="POST" enctype="multipart/form-data">
//         @csrf
//         <label for="file">Choose file:</label>
//         <input type="file" name="file" id="file" required>
//         <button type="submit">Upload</button>
//     </form>
// </body>
// </html>
// ```

// ### Summary

// 1. **Create Symlink**: Use the `ln -s` command to create a symlink.
// 2. **Verify Permissions**: Ensure the target directory has appropriate permissions.
// 3. **Update Filesystem Configuration**: Configure Laravel to use the correct disk.
// 4. **Test Operations**: Ensure file uploads, downloads, and deletions work as expected.

// This setup will allow you to manage files on your Ubuntu server with Laravel effectively.