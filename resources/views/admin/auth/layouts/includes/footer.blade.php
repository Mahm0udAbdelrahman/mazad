<!-- jQuery -->
<script src="{{asset('layout/plugins/jquery/jquery.min.js')}}"></script>
<!-- toastr -->
<script src="{{asset('layout/plugins/toastr/toastr.min.js')}}"></script>
<!--end::Javascript-->
@if (\Session::has('message'))
  <script type="text/javascript">
    $(function(){
        toastr["{{ \Session::get('message')['type'] }}"]('{!! \Session::get("message")["text"] !!}' ,"{{ ucfirst( \Session::get('message')['type'] ) }}!");
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    });
  </script>
  <?php echo \Session::forget('message'); ?>
@endif

@if ($errors->any())
  <script type="text/javascript">
    $(function(){
        toastr["error"]('{{$errors->first()}}' ,"Error!");
    });
  </script>
@endif


@stack('scripts')