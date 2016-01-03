module.exports = function(grunt) {

  grunt.initConfig({

    //Project configuration
    pkg: grunt.file.readJSON('package.json'),



    //Clean
    clean : {
      css: [
        'css/dist/*.css',
        'module/*/dist/*.css',
        'page/*/dist/*.css'
      ],
      sass: [
        'css/dist/*.scss',
        'sass/dist/*.scss'
      ],
      js: [
        'js/dist/*.min.js',
        'module/*/dist/*.min.js',
        'page/*/dist/*.min.js'
      ],
      php: [
        'module/*/dist/*.php',
        'page/*/dist/*.php'
      ],
      dist: [
        'dist/**/*'
      ]
    },



    //Concat Sass
    concat: {
      sass: {
        src: [
          'sass/src/*.scss',
        ],
        dest: 'sass/dist/style.scss'
      }
    },



    //Compile Sass
    sass: {
      options: {
        sourcemap: 'none',
        sourceComments: false
      },
      main: {
        files: {
          'css/dist/style.css': 'sass/dist/style.scss'
        }
      },
      other: {
        files: grunt.file.expandMapping(['module/*/src/*.scss', 'page/*/src/*.scss'], '', {
          rename: function(destBase, destPath) {
            var dir = destPath.substring(0, destPath.search('src')) + 'dist';
            var file = destPath.substring(destPath.search('src') + ('src').length, destPath.length);
            var file = file.replace('.scss', '.css');
            destPath = dir + file;
            return destPath;
          }
        })
      }
    },



    //Minify CSS
    cssmin: {
      options: {
        shorthandCompacting: false,
        roundingPrecision: -1
      },
      main: {
        files: {
          'css/dist/style.min.css': 'css/dist/style.css'
        }
      },
      other: {
        files: grunt.file.expandMapping([
          'module/*/dist/*.css', 'page/*/dist/*.css',
          '!module/*/dist/*.min.css', '!page/*/dist/*.min.css'
        ], '', {
          rename: function(destBase, destPath) {
            destPath = destPath.replace('.css', '.min.css');
            return destPath;
          }
        })
      }
    },


    //Uglify JS
    uglify: {
      main: {
        src: ['js/src/*.js', '!js/src/global_var.js'],  // source files mask
        dest: 'js/dist/',    // destination folder
        expand: true,    // allow dynamic building
        flatten: true,   // remove all unnecessary nesting
        ext: '.min.js'   // replace .js to .min.js
      },
      other: {
        files: grunt.file.expandMapping(['module/*/src/*.js', 'page/*/src/*.js'], '', {
          rename: function(destBase, destPath) {
            var dir = destPath.substring(0, destPath.search('src')) + 'dist';
            var file = destPath.substring(destPath.search('src') + ('src').length, destPath.length);
            var file = file.replace('.js', '.min.js');
            destPath = dir + file;
            return destPath;
          }
        })
      }
    },



    //Copy files
    copy: {
      js: {
        files: [
          {
            expand: true,
            flatten: true,
            src: [
              'js/src/global_var.js'
            ],
            dest: 'js/dist/'
          }
        ]
      },
      php: {
        files: grunt.file.expandMapping(['module/**/src/*.php', 'page/**/src/*.php'], '', {
          rename: function(destBase, destPath) {
            var dir = destPath.substring(0, destPath.search('src')) + 'dist';
            var file = destPath.substring(destPath.search('src') + ('src').length, destPath.length);
            destPath = dir + file;
            return destPath;
          }
        })
      },
      dist: {
        files: [
          {
            expand: true,
            flatten: false,
            src: [
              '.htaccess',
              'config.php',
              'plugin/**/*',
              'css/dist/*',
              'js/dist/*',
              'module/**/*', '!module/*src/*',
              'page/**/*', '!page/*src/*'
            ],
            dest: 'dist/'
          }
        ]
      }
    },



    // Watch and build
    watch: {
      css: {
        files: [
          'sass/src/*.scss',
          'module/*/src/*.scss',
          'page/*/src/*.scss'
        ],
        tasks: ['compileCSS']
      },
      js: {
        files: [
          'js/src/*.js',
          'module/*/src/*.js',
          'page/*/src/*.js'
        ],
        tasks: ['compileJS']
      },
      php: {
        files: [
          'module/*/src/*.php',
          'page/*/src/*.php'
        ],
        tasks: ['compilePHP']
      }
    }


  });



  // Load dependencies
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-sass');



  // Run tasks
  grunt.registerTask('compileCSS', ['clean:css', 'clean:sass', 'concat:sass', 'sass', 'cssmin']);
  grunt.registerTask('compileJS', ['clean:js', 'uglify', 'copy:js']);
  grunt.registerTask('compilePHP', ['clean:php', 'copy:php']);
  grunt.registerTask('compileAll', ['compileCSS', 'compileJS', 'compilePHP']);
  grunt.registerTask('compileDist', ['clean:dist', 'copy:dist']);

};



