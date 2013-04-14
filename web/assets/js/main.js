$(function() {

    $('.code').keydown(function(e) {

        // Detect tab key
        if (e.keyCode === 9) {
            var $this, end, start;
            start = this.selectionStart;
            end = this.selectionEnd;
            $this = $(this);
            $this.val($this.val().substring(0, start) + '    ' + $this.val().substring(end));
            this.selectionStart = this.selectionEnd = start + 4;
            return false;
        }

        // Detect ctrl+enter
        if (e.ctrlKey && e.keyCode == 13) {
            $(this).parents('form').submit();
        }

    });

    // Set initial focus on code textarea
    $('.code').focus();

});