module.exports = function(grunt) {

  grunt.initConfig({

    pkg: grunt.file.readJSON('package.json'), //tells where the json file is



    /**
     * Sass task
     */
     sass: {
       human_read: {
         options: {
           style: 'expanded',
           sourcemap: 'none',
         },
         files: {
           'css/style-human.css': 'sass/style.scss'
         }
       },
      //  materialize: {
      //    options: {
      //      style: 'compressed',
      //      sourcemap: 'none',
      //    },
      //    files: {
      //      'css/materialize.min.css': 'sass/materialize.scss'
      //    }
      //  },
       min_file: {
         options: {
           style: 'compressed',
           sourcemap: 'none',
         },
         files: {
           'css/style.min.css': 'sass/style.scss'
         }
       }
     },

     /**
      * jade
      */
     jade: {
      compile: {
        options: {
          pretty: true,
        },
        files: {
          'index.html': 'index.jade'
        }
      }
    },

     /**
      * autoprefixer
      */

     autoprefixer: {
       options: {
         browser: ['last 2 versions']
       },
       // prefix all files
       multiple_files: {
         expand: false,
         flatten: true,
         src: 'css/style.min.css',
         dest: 'css/style.prefix.min.css'
       }
     },

    /**
     * Watch task
     */
     watch: {
       css: {
         files: '**/*.scss',
         tasks: ['sass', 'autoprefixer'],
         livereload: true
       },
       jade: {
         files: '*.jade',
         tasks: ['jade']
       }
     }

  });

  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-autoprefixer');
  grunt.loadNpmTasks('grunt-contrib-jade');
  grunt.registerTask('default',['watch']);


}
