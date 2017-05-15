pimcore.registerNS("pimcore.plugin.userpermissions");

pimcore.plugin.userpermissions = Class.create(pimcore.plugin.admin, {
    getClassName: function() {
        return "pimcore.plugin.userpermissions";
    },

    initialize: function() {
        pimcore.plugin.broker.registerPlugin(this);
    },
 
    pimcoreReady: function (params,broker){
        // alert("UserPermissions Plugin Ready!");
    }
});

var userpermissionsPlugin = new pimcore.plugin.userpermissions();

