<!-- Bootstrap and necessary plugins -->
<script src="{{ asset('js/vendor/jquery.min.js') }}"></script>
<script src="{{ asset('js/vendor/popper.min.js') }}"></script>
<script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/vendor/pace.min.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/summernote-bs4.js') }}"></script>

<script>

    $(document).ready(function() {

        $('#content').summernote();

    });

</script>
<!-- Plugins and scripts required by all views -->

<!-- CoreUI main scripts -->
<script src="{{ asset('js/admin/app.js')}}"></script>
