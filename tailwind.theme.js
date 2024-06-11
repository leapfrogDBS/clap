const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    
    theme: {

        extend: {
            colors: {
              hoverColor: 'var(--hover-color)',
        },
    },
       
        fontFamily: {
            'sans' : ['Montserrat', 'sans-serif'],
            'tele' : ['Telemarines', 'sans-serif'],
        },  
           
        container: {
            padding: {
                DEFAULT:  '20px',
                lg:       '80px',
            },
            center: true,
        },
    
       
    },

}