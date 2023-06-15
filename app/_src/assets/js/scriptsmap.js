/**
 * Ce fichier permet de gérer les dépendances JS et permet également de les ordonner.
 * @type {{vendors: {npm: string[], libs: string[]}}}
 */

module.exports = {

    vendors: {

        // relative to src/node_modules folder
        npm: [
        ],
        
        // relative to src/assets/js/libs
        libs: [
            'modernizr.js'
        ]
    }

};