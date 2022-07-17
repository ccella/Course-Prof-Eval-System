# CorPES

CorPES (Course/Professor Evaluation System) is a web application designed to be an alternative and improvement to UP Manila's current online and traditional system of evaluation. 

Running this app locally requires XAMPP.

## Running
1) Duplicate the repository

2) Place this repository folder (cmsc128.1mp) inside your /xampp/htdocs folder.

3) Launch XAMPP and Start the Apache and MySQL modules.

4) Open an internet browser and enter localhost in the address bar. The page should show a a directory of files inside htdocs. 

5) Click on the phpMyAdmin folder and import the sql file to a new table named "demo". You don't have to repeat this step when running a second time.

6) Go back to localhost and click on the folder cmsc128.1mp. This should show the login page of the app. You may login using the following credentials.

>user: varthur@up.edu.ph
>
>pass: letmein

## Usage
**Evaluation**
* The home page will show the courses that have yet to be evaluated by the user.
* Click on the "Evaluation" button on top of the app to start evaluating.
* Choose a course from the dropdown list and the corresponding professor.
* After filling up the evaluation form, click on the "Submit" button on the end of the page to finish.

**Course Search**
* This will show the average ratings of the particular course along with a commenting system.
* Click on the "Course Search" button 
* Enter the course's name (e.g., Math 10), and click the search button.

**My Profile**
* This shows the user's profile.
* You may change the nickname by clicking on Edit. 

## Troubleshooting
>**"Going to localhost doesn't show the directory"**

Delete the index.php file in the htdocs folder.

## Contributing
Pull requests are currently only open for project members. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)