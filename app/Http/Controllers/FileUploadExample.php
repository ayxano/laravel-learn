<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PdfFileRequest;
use Illuminate\Support\Facades\Storage;

class FileUploadExample extends Controller
{
    /**
     * Update the avatar for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadAvatar(PdfFileRequest $request)
    {
        /*
        $file = $request->file('file');
        $name = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $path = $file->store('avatars'); */
        $aaa = Storage::putFile('avatars', $request->file('file'));
        return [$aaa];
    }
}
