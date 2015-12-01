module.exports = function(grunt) {

  grunt.initConfig({

    // Project configuration
    pkg: grunt.file.readJSON('package.json'),


    // Delete old concat Sass file
    clean : {
      sass: ['sass/dist/style.scss', 'css/dist/*', 'dist/css/dist/*'],
      js: ['js/dist/*.min.js', 'dist/js/dist/*'],
      php: ['php/dist/*.php', 'dist/*.php', 'dist/php/dist/*'],
      plugin: ['dist/plugin/*']
    },

    // Concat Sass
    concat: {
      sass: {
        src: [
          'sass/src/*.scss',
        ],
        dest: 'sass/dist/style.scss',
      }
    },

    // Compile Sass
    sass: {
      options: {
        sourceMap: false,
        sourceComments: false
      },
      dist: {
        files: {
          'css/dist/style.css': 'sass/dist/style.scss'
        }
      }
    },

    // Minify CSS
    cssmin: {
       dist: {
          files: {
             'css/dist/style.min.css': 'css/dist/style.css'
          }
      }
    },

    // Uglify JS
    uglify: {
        files: {
            src: 'js/src/**/*.js',  // source files mask
            dest: 'js/dist/',    // destination folder
            expand: true,    // allow dynamic building
            flatten: true,   // remove all unnecessary nesting
            ext: '.min.js'   // replace .js to .min.js
        }
    },

    copy: {
      css: {
        files: [
          {expand: true, flatten: true, src: ['css/dist/*'], dest: 'dist/css/dist/', filter: 'isFile'}
        ]
      },
      js: {
        files: [
          {expand: true, flatten: true, src: ['js/dist/*'], dest: 'dist/js/dist/', filter: 'isFile'}
        ]
      },
      php: {
        files: [
          {expand: true, flatten: true, src: 'php/src/**/*.php', dest: 'php/dist/'},
          {expand: true, flatten: true, src: 'php/src/**/*.php', dest: 'dist/php/dist/'},
          {expand: true, flatten: true, src: ['*.php'], dest: 'dist/', filter: 'isFile'}
        ]
      },
      plugin: {
        files: [
          {expand: true, flatten: false, src: 'plugin/**/*', dest: 'dist/'}
        ]
      }
    },

    // Watch and build
    watch: {
      sass: {
        files: 'sass/src/**/*.scss',
        tasks: ['compileSass']
      },
      js: {
        files: 'js/src/**/*.js',
        tasks: ['compileJS']
      },
      php: {
        files: ['*.php', 'php/src/**/*.php'],
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
  grunt.registerTask('compileSass', ['clean:sass', 'concat:sass', 'sass', 'cssmin', 'copy:css']);
  grunt.registerTask('compileJS', ['clean:js', 'uglify', 'copy:js']);
  grunt.registerTask('compilePHP', ['clean:php', 'copy:php']);
  grunt.registerTask('compilePlugin', ['clean:plugin', 'copy:plugin']);
  grunt.registerTask('compileAll', ['compileSass', 'compileJS', 'compilePHP', 'compilePlugin']);

};