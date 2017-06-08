# theta
# Study Support Services

This app is an extension of the barebones application provided together with the University of Coventry 302CEM 2017 coursework assignment.

The app can be directly accessed from Heroku at the following URLS:

https://theta-web.herokuapp.com/ (for students)

https://theta-web.herokuapp.com/indexLecturer.html (for lecturers)

Additional features for students include the ability to view and download resource files as well as to book one-to-one appointments based on lecturer availability.

Additional features for lecturers include the ability to view student appointments, as well as to upload worksheets and other resource materials to the system.

The system is implemented in PHP using PostgreSQL as the database server, and hosted on the Heroku cloud application platform.

Git is used as the software version control tool, both on the local Heroku git repository, and also for version control of the codes on github.

For creating the Heroku git application, a sample Heroku PHP git project was cloned and modified, as explained in [Getting Started with PHP on Heroku](https://devcenter.heroku.com/articles/getting-started-with-php) article.

## Deploying

Install the [Heroku Toolbelt](https://toolbelt.heroku.com/).

```sh
$ git clone git@github.com:heroku/php-getting-started.git # or clone your own fork
$ cd php-getting-started
$ heroku create
$ git push heroku master
$ heroku open
```

or

[![Deploy to Heroku](https://www.herokucdn.com/deploy/button.png)](https://heroku.com/deploy)

## Documentation

For more information about using PHP on Heroku, see these Dev Center articles:

- [Getting Started with PHP on Heroku](https://devcenter.heroku.com/articles/getting-started-with-php)
- [PHP on Heroku](https://devcenter.heroku.com/categories/php)
