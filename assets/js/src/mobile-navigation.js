const siteTitle = document.title;
Mmenu.configs.offCanvas.page.selector = "#site-content";

document.addEventListener(
    "DOMContentLoaded", () => {
        

        // menu var
        const menu = new Mmenu( "#mobile-menu", {
            
        extensions: ["position-top", "fullscreen", "border-full"],
        navbars: [
            {
                content: [
                    // Site title
                    '<h1>'+siteTitle+'</h1>'
                ]
            },
            {
                // second option
            }
        ]
        
    });
        
    const api = menu.API;
        
    document.querySelector( "#mobile-toggler" )
        .addEventListener(
            "click", ( evnt ) => {
                evnt.preventDefault();
                api.open();
                api.close();
            }
        );
    }
);