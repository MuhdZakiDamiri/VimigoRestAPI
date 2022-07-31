THIS IS FOR VIMIGO REST API

REST api Assesment


Requirements:
1. You are required to do CRUD functions using User Model ([POST]/login &
    [POST]/register is not considered as part of CRUD)
2. The CRUD functions need to be REST API
3. Your API can only be accessed if the user is authenticated through Laravel Passport.
    
    - route :
        Route::group(['prefix' => 'users','middleware' => ['auth:api']], function() {
            Route::get('/','App\Http\Controllers\userController@listing');

            Route::post('/add-user', 'App\Http\Controllers\userController@fileUploadAddUser');
            Route::post('/delete-user', 'App\Http\Controllers\userController@fileUploadDeleteUser');
        });
    
4. All of your inputs need to be validated. You need to use Laravel Form Request Validation.
    
    - the validation is inside file :
        - userController
        - authUserController
    
5. Your [GET]/api/users able to filter by name and/or email and have pagination.
    
    - route for this function :
        - Route::get('/','App\Http\Controllers\userController@listing');
    
6. when retrieving the data, only need to show name and email using Laravel API Resource.
    
    - the resource file is inside :
        - App/http/Resources/UserResource.php

7. You also need to have an API to import excel/csv files to do bulk Create, Update and Delete users.
    
    - route for add and update :
        -     Route::post('/add-user', 'App\Http\Controllers\userController@fileUploadAddUser');
    - route for delete :
        -     Route::post('/delete-user', 'App\Http\Controllers\userController@fileUploadDeleteUser');

8. Save all of the requests and responses as a Postman collection, and include the Postman
    JSON link in your README.md.

    - link :
        - https://www.getpostman.com/collections/c0c95783dcb69d124c7f
        
        
9. additional information:
    
    - database config in  .env : 
        - DB_CONNECTION=mysql
          DB_HOST=127.0.0.1
          DB_PORT=3306
          DB_DATABASE=vimigo-api
          DB_USERNAME=root
          DB_PASSWORD=
        
        - database structure :
        - ![image](https://user-images.githubusercontent.com/105404308/181866892-d931146a-47e0-464f-b51a-b423ed630972.png)

        - ![image](https://user-images.githubusercontent.com/105404308/181866886-e0902963-0ecb-4470-9ab5-5b8214533e09.png)

          
    - file for csv is inside :
        - public/uploads






