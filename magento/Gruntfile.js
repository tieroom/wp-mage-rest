module.exports = function(grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        watch: {
            grunt: { files: ['Gruntfile.js'] },
            sass: {
                files: ['skin/frontend/rwd/default/scss/**/*.scss'],
                tasks: ['sass']
            }
        },

        sass: {
            files: {
                'skin/frontend/rwd/default/css/wp-mage-rest.css': 'skin/frontend/rwd/default/scss/wp-mage-rest.scss'
            }
        }

    });


    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-sass');

    grunt.registerTask('default', ['watch']);
};
