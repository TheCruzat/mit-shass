/*
 *		Dev taskrunner
 * 		by Dan Cruzat for Centric Park
 *		adapted from https://github.com/TheCruzat/WordPress-Gulp4-Starter/blob/master/wp-content/wp-gulp-starter/gulpfile.js
 */

const
	// routes + paths

	src = './',
	dest = 'assets',

	paths = {
		src: {
			scss: src + 'sass/**/*.scss',
			js: src + 'js/**/*.js',
			php: src + '**/*.php',
			img: src +'img/**/*.+(png|jpg|gif|svg|ico)'
		},
		dest: {
			js: dest + '/js',
			css: dest + '/css'
		}
	},

	// imports

	autoprefixer = require('autoprefixer'),
	cssnano = require('cssnano'),
	gulp = require('gulp'),
	sass = require('gulp-sass')(require('sass')),
	postcss = require('gulp-postcss'),
	rename = require('gulp-rename'),
	ugly = require('gulp-uglify');

// style function, collect + minify

	function style() {
	  return gulp
	  	.src(paths.src.scss)
	    .pipe(sass())
	    .on('error', sass.logError)
	    .pipe(postcss([ autoprefixer(), cssnano() ]))
	    .pipe(rename({
	        extname: '.min.css'
	     }))
	    .pipe(gulp.dest(paths.dest.css));
	    ;
	}
	gulp.task('style', style);

// script function, collect + minify

	function script() {
		return gulp
			.src(paths.src.js)
			.pipe(ugly())
	    .pipe(rename({
	        extname: '.min.js'
	     }))
      .pipe(gulp.dest(paths.dest.js));
	}
	gulp.task('script', script);

// the watcher on the wall

	function watch() {
	  gulp.watch(paths.src.scss, style);
	  gulp.watch(paths.src.js, script);
	}

	gulp.task('default', watch);
