'use strict';
 
const gulp 				= require('gulp');
const gulpLoadPlugins 	= require('gulp-load-plugins');

const buffer        	= require('vinyl-buffer');
const merge         	= require('merge-stream');

const $ 				= gulpLoadPlugins();

var vendorScripts = [
	'src/jquery/dist/jquery.min.js',
	//'src/popper.js/dist/umd/popper.min.js',
	//'src/bootstrap/dist/js/bootstrap.min.js',
	'src/slick-carousel/slick/slick.min.js',
	//'src/ion.rangeSlider-2.2.0/js/ion-rangeSlider/ion.rangeSlider.min.js',
	//'src/fancybox-master/dist/jquery.fancybox.min.js',
	'src/jquery.dropotron.min.js',
	'src/jquery.scrollgress.min.js',
	'src/skel.min.js',
	'src/util.js',
	//'src/video.js/dist/video.js',
	//'src/modernizr.js',
];
 
gulp.task('sass', function () {
  	return gulp.src('./styles/**/*.scss')
	  	.pipe($.sourcemaps.init())
	    //.pipe($.sass({outputStyle: 'compressed'}).on('error', $.sass.logError))
	    .pipe($.sass({outputStyle: 'expanded'}).on('error', $.sass.logError))
	  	//.pipe($.autoprefixer())
	    .pipe($.sourcemaps.write('.'))
	    .pipe(gulp.dest('./styles'));
});

// Fonts
gulp.task('fonts', function() {
    return gulp.src(['src/font-awesome/fonts/*'])
    .pipe(gulp.dest('fonts'));
});

//scripts
gulp.task('buildScripts', function() {
	gulp.src(vendorScripts)
	    .pipe($.concat('vendor.js'))
	    //.pipe($.uglify())
	    .pipe(gulp.dest('scripts'));
});
 
//sprite images
gulp.task('sprite', function () {
  // Generate our spritesheet 
  var spriteData = gulp.src('./images/sprite/*.png')
    .pipe($.spritesmith({
      imgName: 'sprite.png',
      cssName: '_sprite.scss',
      imgPath: '../images/sprite.png',
      //algorithm: 'diagonal',
      paddingNumber: 20,
      cssOpts: {
        'functions': false
      }
    }));

  // Pipe image stream through image optimizer and onto disk 
  var imgStream = spriteData.img
    .pipe(buffer($.imagemin()))
    .pipe(gulp.dest('./images/'));

  // Pipe CSS stream through CSS optimizer and onto disk 
  var cssStream = spriteData.css
    .pipe(gulp.dest('./styles/includes/'));
 
  // Return a merged stream to handle both `end` events 
  return merge(imgStream, cssStream);
});

gulp.task('watch', ['buildScripts', 'fonts'], function () {
  	gulp.watch('./styles/**/*.scss', ['sass']);
  	gulp.watch('./images/sprite/*', ['sprite']);
});