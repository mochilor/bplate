# Simple boiler plate for small PHP web development.

Based on great [HTML5 Boilerplate](https://html5boilerplate.com/) and intended for small php apps. It uses a small custom routing (it needs url rewriting to be activated on server) and have no classes nor autoloading. Public assets are in webroot folder. Pages files (views) are in /app/pages. If you need a new url, simply add a new file here named as the desired url. Each section after first slash will be treated as parameters and passed to page file.

## Gulp

Includes a gulpfile for handle resources files and put concatenated and minified files under webroot folder. If you plan not to use gulp, you must replace main.min.css and main.min.js with your own files.

### Included frontend libraries via bower:
- Bootstrap
- Fontawesome
- jQuery
- jQuery validation

Install libraries with:

```
npm install
gulp bower
```

Deafult `bower` task will watch for changes in resources folders.

###Missing features (also known as TO DO!)
- Javascript and server side simple validation.
- Database management (basic CRUD).
- ...