var Dashboard = function() {
  
    // ------------------------------------------------------------------------
  
    this.__construct = function() {
        console.log('Dashboard Created');
        Template= new Template();
        Event   = new Event();
        //Result  = new Result();
        load_todo();
        load_note();
    };
    
    // ------------------------------------------------------------------------
    
    var load_todo = function() {
        $.get('api/get_todo', function(o) {
            var output = '';
            for (var i = 0; i < o.length; i++) {
                output += Template.todo(o[i]);
            }
            
            $("#list_todo").html(output);
        }, 'json');
    };
    
    // ------------------------------------------------------------------------
    
    var load_note = function() {
        $.get('api/get_note', function(o) {
            var output = '';
            for (var i = 0; i < o.length; i++) {
                output += Template.note(o[i]);
            }
            
            $("#list_note").html(output);
        }, 'json');
    }; 
    
    // ------------------------------------------------------------------------
    
    this.__construct();
    
};
