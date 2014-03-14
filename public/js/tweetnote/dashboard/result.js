var Result = function() {
  
    // ------------------------------------------------------------------------
  
    this.__construct = function() {
    };
    
    // ------------------------------------------------------------------------
    
    this.success = function(msg) {
        var dom = $("#success");
        if (typeof msg === 'undefined') {
            dom.html('Success').fadeIn();
        }
        dom.html(msg).fadeIn();
        
        setTimeout(function() {
            dom.fadeOut();
        }, 5000);
    };
    
    // ------------------------------------------------------------------------
    
    this.error = function(msg) {
        var dom = $("#error");
        
        if (typeof msg === 'undefined') {
            dom.html('Error').fadeIn();;
        }
        
        if (typeof msg === 'object') {
            var output = '<ul>';
            for (var key in msg) {
                output += '<li>' + msg[key] + '</li>';
            }
            output += '</ul>';
            
            dom.html(output).fadeIn();
        }
        else {
            dom.html(msg).fadeIn();
        }
        
        setTimeout(function() {
            dom.fadeOut();
        }, 5000);
    };
    
    // ------------------------------------------------------------------------
    
    this.__construct();
    
};
