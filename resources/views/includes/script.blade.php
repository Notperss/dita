<script src="{{ asset('/assets/static/js/components/dark.js') }}"></script>
<script src="{{ asset('/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

<script src="{{ asset('/assets/compiled/js/app.js') }}"></script>


<!-- Need: Apexcharts -->
<script src="{{ asset('/assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('/assets/static/js/pages/dashboard.js') }}"></script>

<script src="{{ asset('/assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
<script src="{{ asset('/assets/static/js/pages/simple-datatables.js') }}"></script>

<script src="{{ asset('/assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('/assets/static/js/pages/sweetalert2.js') }}"></script>

<script src="{{ asset('assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
<script src="{{ asset('assets/static/js/pages/form-element-select.js') }}"></script>

<script>
  function submitForm() {
    Swal.fire({
      title: 'Submit Confirmation',
      text: 'Are you sure you want to submit?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Yes, submit it!',
      cancelButtonText: 'No, cancel!',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        // If confirmed, submit the form
        document.getElementById('myForm').submit();
      }
    });
  }
</script>
