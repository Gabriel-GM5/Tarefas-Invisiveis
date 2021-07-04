<main>
    <script>
        $(document).ready(function() {
            var success = "<?php $this->session->flashdata('success'); ?>";
            var error = "<?php $this->session->flashdata('error'); ?>";
            if (success) {
                M.toast({
                    html: success,
                    classes: 'rounded'
                });
            }
            if (error) {
                M.toast({
                    html: success,
                    classes: 'rounded'
                });
            }
        });
    </script>
    <div class="container">