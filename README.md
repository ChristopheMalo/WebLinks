# WebLinks

A Silex application to manage weblinks.

## Presentation
WebLinks is a minimalist Web application type management url links. It is built by successive iterations. Each branch of this repository equal to the result obtained at the end of an iteration.

## The main characteristics
The main characteristics of this application are:

- Viewing the list of weblinks
- Using the MVC design pattern
- Integration of micro-framework Silex
- Object modeling domain and data access
- Use of namespaces and automatic loading of classes with Composer
- Dependency management with Composer
- Integration of Twig template engine to facilitate writing views
- Integration of Bootstrap framework
- Add a backoffice to manage links and user (add, update and delete)
- Add a JSON API to manage weblinks (show a list or one link - no delete - no add)
- Automated functional testing consulting URL (URL to be tested)
- Logging and error handling
- Written controller as classes, specific one for user area

## Iteration 1

The purpose: display the list of all weblinks

- Fork the app
- Clone the app
- Create the branch 'develop' and the first 'feature branch'
- Check the folders (for files) respecting the MVC design pattern
- Load the dependancies for this iteration
- Initialize the application on a local machine (virtual host, database...)
- Test the application
- Check the files
- Model the diagram class for this iteration
- Model the database schema
- Fixe the index view to show correctly the weblinks
- Code a simple user class (without password and role) to display username in index view
- Complete documentation of all classes and methods according to my method
- Code the Home controller
- Add testing tool and error handling tool (debug bar)
- Add phpunit tests

## Iteration 2

The purpose: develop the backoffice application to manage links and users

- Update composer to add security and form dependencies
- Update User class (role, password)
- Update UserDAO class
- Code access menu in layout view and login form (view)
- Code AdminController to display links and users (indexAction)
- Code the admin view
- Update routes (add routes) and app (register services)
- Code all the types of form
- Code the form views (user and link)
- Code AdminController to manage users and links
- Add favicon
- Add robots.txt file
- Code Submit Link on top for user connected (Minimum ROLE_USER)
- Code UseArea controller for add link and for future user actions (manage profile, manage his links...)
- Update phpunit test urls

## Iteration 3

- Code JSON API to display all links and detailed link
- Custom error message
- Pass the insight sensiolabs test

## Copyright
**An original idea of Baptiste Pesquet for :** [a work practice of Openclassrooms](https://openclassrooms.com/courses/evoluez-vers-une-architecture-php-professionnelle) - **Adapted and directed :** Christophe Malo
