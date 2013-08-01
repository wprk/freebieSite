$(function() {

    // Prepare
    var History = window.History; // Note: We are using a capital H instead of a lower h
    if ( !History.enabled ) {
        // History.js is disabled for this browser.
        // This is because we can optionally choose to support HTML4 browsers or not.
        return false;
    }

    // Bind to StateChange Event
    History.Adapter.bind(window,'statechange',function() { // Note: We are using statechange instead of popstate
        var State = History.getState();
        $('#header div.wrap').load(State.url + " #header div.wrap");
        $('#sub_categories').load(State.url + " #sub_categories");
        $('#content .right').load(State.url + " #content .right");
        $('#content .left').load(State.url + " #content .left");
    });

    $('a').not("a[href^='http']").click(function(evt) {
        evt.preventDefault();
        History.pushState(null, $(this).text(), $(this).attr('href'));
    });
    // $("a[href^='http']").attr('target', '_blank');
});