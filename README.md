THIS IS FOR VIMIGO REST API

REST api Assesment


Requirements:
1. You are required to do CRUD functions using User Model ([POST]/login &
    [POST]/register is not considered as part of CRUD)
2. The CRUD functions need to be REST API
3. Your API can only be accessed if the user is authenticated through Laravel Passport.

    - result if no authorization :
        ![image](https://user-images.githubusercontent.com/105404308/181810810-10560674-d686-4c12-8117-facc38a1cb6c.png)

    - result if has authorization :
        ![image](https://user-images.githubusercontent.com/105404308/181810886-32a631f9-ed7c-4f1c-8be4-928f94e01c86.png)


4. All of your inputs need to be validated. You need to use Laravel Form Request Validation.

    - validation for auth :
        
        ![image](https://user-images.githubusercontent.com/105404308/181811102-91164493-fb13-4483-b8b8-4548e6fcea38.png)


5. Your [GET]/api/users able to filter by name and/or email and have pagination.

6. when retrieving the data, only need to show name and email using Laravel API Resource.

7. You also need to have an API to import excel/csv files to do bulk Create, Update and Delete users.

8. The project progress can be tracked using any version-control system (e.g: Upload in GitHub)

9. Save all of the requests and responses as a Postman collection, and include the Postman
    JSON link in your README.md.
