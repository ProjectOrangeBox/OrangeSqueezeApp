const {
	series,
	parallel,
	src,
	dest,
	watch
} = require("gulp");
const sass = require("gulp-sass");
const uglify = require("gulp-uglify");
const pug = require("gulp-pug");
const concat = require("gulp-concat");
const cleanCSS = require("gulp-clean-css");
const del = require("del");
const fs = require("fs");
const path = require("path");
const replace = require("gulp-string-replace");

/* attach the sass compiler to the sass class */
sass.compiler = require("node-sass");

const tempFolder = "var/gulp"; /* relative */
const distFolder = "/var/www/bbb/repro/public/dist"; //path.join(process.cwd(),'/../../../var/www/html/dist');
const includeSourceMaps = false;
const pugViewFolder = "application/views";

console.log("Destination Folder: " + distFolder);

/* make sure it's there */
fs.mkdir(distFolder, {}, function (err) {});

/* build our arrays of assets */
let pugViews = [];

let copyDir = {
	"node_modules/font-awesome/fonts/*": "fonts",
	"node_modules/roboto-fontface/fonts/roboto/*": "fonts/roboto",
	"node_modules/bootstrap3/fonts/*": "fonts"
};

let copyFile = {
	"var/gulp/bundle.css": "css",
	"var/gulp/bundle.js": "js"
};

let js = {
	vendor: [
		"node_modules/jquery/dist/jquery.js",
		"node_modules/bootstrap/dist/js/bootstrap.js",
		"node_modules/jstorage/jstorage.js",
		"node_modules/handlebars/dist/handlebars.js",
		"node_modules/bootbox/dist/bootbox.min.js",
		"node_modules/sprintf-js/src/sprintf.js",
		"node_modules/tinybind/dist/tinybind.min.js"
	],
	user: ["assets/js/application.js"]
};

let css = {
	vendor: [
		"node_modules/bootstrap/dist/css/bootstrap.css",
		"node_modules/roboto-fontface/css/roboto/roboto-fontface.css",
		"node_modules/font-awesome/css/font-awesome.css"
	],
	user: ["assets/application.css"],
	scss: ["assets/css/application.scss"]
};

/* auto build the watch arrays */
var watchFiles = Array.prototype.concat(
	pugViews,
	css.user,
	css.vendor,
	css.scss,
	js.vendor,
	js.user
);
var watchFilesJs = Array.prototype.concat(js.user);
var watchFilesCss = Array.prototype.concat(css.user, css.vendor, css.scss);
var watchFilesPug = pugViews;

/* my tasks */

function setUp(callback) {
	return del([tempFolder + "/*.js", tempFolder + "/*.css"], callback);
}

function tearDown(callback) {
	return del([tempFolder + "/*.js", tempFolder + "/*.css"], callback);
}

function compilePug(callback) {
	try {
		return src(pugViews, {
				allowEmpty: true
			})
			.pipe(
				pug({
					pretty: false
				})
			)
			.pipe(
				dest(pugViewFolder, {
					cwd: distFolder,
					overwrite: true
				})
			);
	} catch (e) {
		return callback();
	}
}

function compileJsVendor(callback) {
	try {
		return src(js.vendor, {
				sourcemaps: includeSourceMaps,
				allowEmpty: true
			})
			.pipe(uglify())
			.pipe(concat("vendor.js"))
			.pipe(
				dest(tempFolder, {
					overwrite: true,
					sourcemaps: includeSourceMaps
				})
			);
	} catch (e) {
		return callback();
	}
}

function compileJsUser(callback) {
	try {
		return src(js.user, {
				sourcemaps: includeSourceMaps,
				allowEmpty: true
			})
			.pipe(uglify())
			.pipe(concat("user.js"))
			.pipe(
				dest(tempFolder, {
					overwrite: true,
					sourcemaps: includeSourceMaps
				})
			);
	} catch (e) {
		return callback();
	}
}

function combinedJs(callback) {
	try {
		/* these are in the order we want them compiled */
		return src([tempFolder + "/vendor.js", tempFolder + "/user.js"], {
				allowEmpty: true
			})
			.pipe(concat("bundle.js"))
			.pipe(
				dest(tempFolder, {
					overwrite: true,
					sourcemaps: includeSourceMaps
				})
			);
	} catch (e) {
		return callback();
	}
}

function compileCssVendor(callback) {
	try {
		return src(css.vendor, {
				sourcemaps: includeSourceMaps,
				allowEmpty: true
			})
			.pipe(concat("vendor.css"))
			.pipe(
				dest(tempFolder, {
					overwrite: true,
					sourcemaps: includeSourceMaps
				})
			);
	} catch (e) {
		return callback();
	}
}

function compileSassUser(callback) {
	try {
		return src(css.scss, {
				sourcemaps: includeSourceMaps,
				allowEmpty: true
			})
			.pipe(sass())
			.pipe(concat("sass.css"))
			.pipe(
				dest(tempFolder, {
					overwrite: true,
					sourcemaps: includeSourceMaps
				})
			);
	} catch (e) {
		return callback();
	}
}

function compileCssUser(callback) {
	try {
		return src(css.user, {
				sourcemaps: includeSourceMaps,
				allowEmpty: true
			})
			.pipe(concat("user.css"))
			.pipe(
				dest(tempFolder, {
					overwrite: true,
					sourcemaps: includeSourceMaps,
					allowEmpty: true
				})
			);
	} catch (e) {
		return callback();
	}
}

function combinedCss(callback) {
	try {
		/* these are in the order we want them compiled */
		return src(
				[
					tempFolder + "/vendor.css",
					tempFolder + "/sass.css",
					tempFolder + "/user.css"
				], {
					allowEmpty: true
				}
			)
			.pipe(
				cleanCSS({
					sourceMap: includeSourceMaps,
					compatibility: "ie9"
				})
			)
			.pipe(concat("bundle.css"))
			.pipe(replace(/url\(\.\.\/\.\.\/fonts\/roboto/g, "url(../fonts/roboto"))
			.pipe(
				dest(tempFolder, {
					overwrite: true,
					sourcemaps: includeSourceMaps
				})
			);
	} catch (e) {
		return callback();
	}
}

function copyDirectories(callback) {
	if (Object.keys(copyDir).length) {
		for (let idx in copyDir) {
			try {
				src(idx, {
					allowEmpty: true
				}).pipe(
					dest(copyDir[idx], {
						cwd: distFolder,
						overwrite: true,
						sourcemaps: includeSourceMaps,
						allowEmpty: true
					})
				);
			} catch (e) {
				return callback();
			}
		}
	}

	return callback();
}

function copyFiles(callback) {
	if (Object.keys(copyFile).length) {
		for (let idx in copyFile) {
			try {
				src(idx, {
					allowEmpty: true
				}).pipe(
					dest(copyFile[idx], {
						cwd: distFolder,
						overwrite: true,
						sourcemaps: includeSourceMaps
					})
				);
			} catch (e) {
				return callback();
			}
		}
	}

	return callback();
}
/* commands */

exports.watch = function () {
	return watch(
		watchFiles,
		series(
			setUp,
			parallel(
				parallel(compileJsVendor, compileJsUser),
				parallel(compileSassUser, compileCssVendor, compileCssUser),
				compilePug
			),
			parallel(combinedJs, combinedCss),
			copyDirectories,
			copyFiles,
			tearDown
		)
	);
};

exports.watchJs = function () {
	return watch(
		watchFilesJs,
		series(
			setUp,
			parallel(compileJsVendor, compileJsUser),
			combinedJs,
			copyDirectories,
			copyFiles,
			tearDown
		)
	);
};

exports.watchCss = function () {
	return watch(
		watchFilesCss,
		series(
			setUp,
			parallel(compileSassUser, compileCssVendor, compileCssUser),
			combinedCss,
			copyDirectories,
			copyFiles,
			tearDown
		)
	);
};

exports.watchPug = function () {
	return watch(watchFilesPug, series(setUp, compilePug, tearDown));
};

exports.compilePug = series(setUp, compilePug, tearDown);

exports.compileCss = series(
	setUp,
	parallel(compileSassUser, compileCssVendor, compileCssUser),
	combinedCss,
	copyDirectories,
	copyFiles,
	tearDown
);

exports.compileJs = series(
	setUp,
	parallel(compileJsVendor, compileJsUser),
	combinedJs,
	copyDirectories,
	copyFiles,
	tearDown
);

exports.copy = series(copyDirectories, copyFiles);
exports.combined_css = series(combinedCss);
exports.combined_js = series(combinedJs);

exports.default = series(
	setUp,
	parallel(
		parallel(compileJsVendor, compileJsUser),
		parallel(compileSassUser, compileCssVendor, compileCssUser),
		compilePug
	),
	parallel(combinedJs, combinedCss),
	copyDirectories,
	copyFiles,
	tearDown
);