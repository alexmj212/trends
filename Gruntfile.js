module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		connect : {
			options : {
				livereload : true,
				port : 9001,
				base: "."
			},
			dev : {
				middleware: function (connect) {
					return [
						require('connect-livereload')() // <--- here
					];
				}
			}
		},
		jshint : {
			all:['js/trends.js']
		},
		less : {
			development : {
				files : 
				[{
					expand : true, // Enable dynamic expansion.
					cwd : "less/", // Src matches are relative to this path.
					src : ["*.less"], // Actual pattern(s) to match.
					dest : "css/", // Destination path prefix.
					ext : ".css" // Dest filepaths will have this extension.
				}]
			}
		},
		uglify : {
			javascript : {
				files : 
				[{
					expand : true, // Enable dynamic expansion.
					cwd : "js/", // Src matches are relative to this path.
					src : ["*.js",'!*.min.js'], // Actual pattern(s) to match.
					dest : "js/", // Destination path prefix.
					ext : ".min.js" // Dest filepaths will have this extension.
				}],
				options : {
					sourceMap: "*.map"
				}
			}
		},
		watch : {
			js : {
				files : ['js/*.js'],
				tasks : ['uglify'],
				options : {
					livereload : true
				}
			},
			less : {
				files : ['less/*.less'],
				tasks : ['less'],
				options : {
					livereload : true
				}
			},
			html : {
				files : ['index.html'],
				options : {
					livereload : true
				}
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-connect');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-git');
	grunt.loadNpmTasks('grunt-shell');

	// Set up tasks with registerTask(<task-name>,<list-of-tasks-from-initConfig>)
	grunt.registerTask('start', ['connect','watch']);
	grunt.registerTask('validate-js', ['jshint:all']);
	grunt.registerTask('compile-less-dev', ['less']);
	grunt.registerTask('run-tests', ['qunit:all']);
	grunt.registerTask('build', ['uglify','less']);
};