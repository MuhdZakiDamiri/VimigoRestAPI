<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class userController extends Controller
{

    public function listing(Request $request)
    {

        $filter = [
            'name' => $request->name ?? '',
            'email' => $request->email ?? ''
        ];

        $user_listing = UserResource::collection(User::get_by_name_or_email($filter));

        return $user_listing;
    }


    public function fileUploadAddUser(Request $request)
    {
        $status = false;
        $message = "";

        $file = $request->file('uploaded_file');
        if ($file) {
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension(); //Get extension of uploaded file
            $fileSize = $file->getSize(); //Get size of uploaded file in bytes

            $this->checkUploadedFileProperties($extension, $fileSize);

            $location = 'uploads';
            $file->move($location, $filename);
            $filepath = public_path($location . "/" . $filename);

            $file = fopen($filepath, "r");
            $importData_arr = array(); // Read through the file and store the contents as an array
            $i = 0;

            //Read the contents of the uploaded file
            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                $num = count($filedata);

                if ($i == 0) {
                    $i++;
                    continue;
                }

                for ($c = 0; $c < $num; $c++) {
                    $importData_arr[$i][] = $filedata[$c];
                }
                $i++;
            }

            fclose($file);

            $j = 0;
            foreach ($importData_arr as $importData) {
                $j++;
                // dd($importData);

                $validator = Validator::make($importData, [
                    '0' => 'required',
                    '1' => 'required|email|unique:Users,email',
                    '2' => [
                        'required',
                        'min:8',
                    ],
                ])->setAttributeNames([
                    '0' => 'User name',
                    '1' => 'User email',
                    '2' => 'User password'
                ]);

                if(!$validator->fails()){
                    User::updateOrCreate( //this will Create or update database table user
                        [
                            'email' => $importData[1],
                        ],[
                            'name' => $importData[0],
                            'email' => $importData[1],
                            'password' => Hash::make($importData[2])
                        ]
                    );

                    $status = true;
                    $message = "User has successfully create or update";
                }else{

                    return response([
                        'status' => false,
                        'message' =>"Error for user name: ". $importData[0] . " " . implode(" ",$validator->errors()->all()). " Other user before will continue to be create"
                    ]);
                }

            }

            return response([
                'status' => $status,
                'message' => $message
            ]);


        } else {
            return response([
                'status' => false,
                'message' => 'No file was uploaded'
            ]);
        }
    }


    public function fileUploadDeleteUser(Request $request)
    {
        $file = $request->file('uploaded_file');
        if ($file) {
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension(); //Get extension of uploaded file
            $fileSize = $file->getSize(); //Get size of uploaded file in bytes

            $this->checkUploadedFileProperties($extension, $fileSize);

            $location = 'uploads';
            $file->move($location, $filename);
            $filepath = public_path($location . "/" . $filename);

            $file = fopen($filepath, "r");
            $importData_arr = array(); // Read through the file and store the contents as an array
            $i = 0;

            //Read the contents of the uploaded file
            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                $num = count($filedata);

                if ($i == 0) {
                    $i++;
                    continue;
                }

                for ($c = 0; $c < $num; $c++) {
                    $importData_arr[$i][] = $filedata[$c];
                }
                $i++;
            }

            fclose($file);

            $j = 0;
            foreach ($importData_arr as $importData) {
                $j++;

                //delete user
                User::where([
                        'email' => $importData[1],
                    ])->delete();
            }

            return response([
                'status' => true,
                'message' => "$j records successfully deleted"
            ]);
        } else {
            return response([
                'status' => false,
                'message' => 'No file was uploaded'
            ]);
        }
    }


    public function checkUploadedFileProperties($extension, $fileSize)
    {
        $valid_extension = array("csv", "xlsx");
        $maxFileSize = 2097152; // Uploaded file size limit is 2mb
        if (in_array(strtolower($extension), $valid_extension)) {
            if ($fileSize <= $maxFileSize) {

            } else {
                throw new \Exception('No file was uploaded', Response::HTTP_REQUEST_ENTITY_TOO_LARGE); //413 error
            }
        } else {
            throw new \Exception('Invalid file extension', Response::HTTP_UNSUPPORTED_MEDIA_TYPE); //415 error
        }
    }

}
