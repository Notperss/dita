{{-- <script>
  $(document).ready(function() {
    $('#modalupload').on('shown.bs.modal', function() {
      const element = document.querySelector('.js-example-basic-multiple');
      const choices = new Choices(element, {
        removeItemButton: true, // Allows users to remove selected items
        shouldSort: false, // Disable sorting to keep options in the order they're added
      });
    });
  });
</script> --}}
<script>
  updateList = function() {
    var input = document.getElementById('file');
    var output = document.getElementById('fileList');
    var children = "";
    for (var i = 0; i < input.files.length; ++i) {
      children += '<li>' + input.files.item(i).name + '</li>';
    }
    output.innerHTML = '<ul>' + children + '</ul>';
  }
</script>

<div class="modal fade" id="modalupload" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
        <a href="{{ url()->previous() }}" type="button" class="close btn" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </a>
      </div>
      <form class="form" action="{{ route('folder.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <input type="hidden" name="id" id="id" value="{{ $id }}">
          <div class="row">

            <div class="form-group row">
              <label class="col-md-4 form-label" for="number">Nomor
                <code style="color:red;">*</code></label>
              <div class="col-md-8">
                <input type="text" class="form-control" id="number" name="number">
                @if ($errors->has('number'))
                  <p style="font-style: bold; color: red;">
                    {{ $errors->first('number') }}</p>
                @endif
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-4 form-label" for="date">Tanggal
                <code style="color:red;">*</code></label>
              <div class="col-md-8">
                <input type="date" class="form-control" id="date" name="date">
                @if ($errors->has('date'))
                  <p style="font-style: bold; color: red;">
                    {{ $errors->first('date') }}</p>
                @endif
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-4 form-label" for="description">Keterangan
              </label>
              <div class="col-md-8">
                <textarea type="text" class="form-control" id="description" name="description" rows="5"></textarea>
                @if ($errors->has('description'))
                  <p style="font-style: bold; color: red;">
                    {{ $errors->first('description') }}</p>
                @endif
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-4 label-control" for="file">File
                <code style="color:red;">*</code></label>
              <div class="col-md-8">
                <input type="file" class="form-control" id="file" name="file[]" onchange="updateList()"
                  multiple>
                <label class="form-label" for="file" aria-describedby="file">Pilih
                  File</label>
              </div>
              @if ($errors->has('file'))
                <p style="font-style: bold; color: red;">
                  {{ $errors->first('file') }}</p>
              @endif
              <p class="col-md-4">Selected File :</p>
              <div id="fileList" style="word-break: break-all"></div>

              <label class="col-md-6 form-label" for="name">Sertakan File di Notifikasi</label>
              <div class="col-md-6">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" value="1" type="radio" name="attach_file" id="enable">
                  <label class="form-check-label" for="enable">
                    Ya
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input col-md-4" type="radio" name="attach_file" id="disable" checked>
                  <label class="form-check-label" for="disable">
                    Tidak
                  </label>
                </div>
                @if ($errors->has('name'))
                  <p style="font-style: bold; color: red;">
                    {{ $errors->first('name') }}</p>
                @endif
              </div>
            </div>

            <hr>

            <div class="form-group row">
              <label class="col-md-4 form-label" for="name">Notifikasi</label>
              <div class="col-md-8">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="notification_radio" id="enable_notification">
                  <label class="form-check-label" for="enable_notification">
                    Ya
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input col-md-4" type="radio" name="notification_radio"
                    id="disable_notification" checked>
                  <label class="form-check-label" for="disable_notification">
                    Tidak
                  </label>
                </div>
                @if ($errors->has('name'))
                  <p style="font-style: bold; color: red;">
                    {{ $errors->first('name') }}</p>
                @endif
              </div>
            </div>


            <div id="notificationFields" style="display: none;">
              <div class="form-group row">
                <label class="col-md-4 form-label" for="notification">Nama Pengingat</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" id="notification" name="notification">
                  @if ($errors->has('notification'))
                    <p style="font-style: bold; color: red;">
                      {{ $errors->first('notification') }}</p>
                  @endif
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-4 form-label" for="date_notification">Tanggal </label>
                <div class="col-md-8">
                  <input type="date" class="form-control" id="date_notification" name="date_notification">
                  @if ($errors->has('date_notification'))
                    <p style="font-style: bold; color: red;">
                      {{ $errors->first('date_notification') }}</p>
                  @endif
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-4 form-label" for="email">Email</label>
                <div class="col-md-8">
                  <input type="email" class="form-control" id="email" name="email"
                    placeholder="Enter Email">
                  @if ($errors->has('email'))
                    <p style="font-style: bold; color: red;">
                      {{ $errors->first('email') }}</p>
                  @endif
                </div>
              </div>

              <div class="form-group row">
                <label class="col-md-4 form-label" for="addCC">Add CC</label>
                <div class="col-md-6">
                  <input type="email" class="form-control" id="addCC" placeholder="Enter CC">
                  <div id="emailError" style="display:none; color: red; font-weight: bold;">
                    Invalid email address.
                  </div>
                  @if ($errors->has('email_cc'))
                    <p style="font-style: bold; color: red;">
                      {{ $errors->first('email_cc') }}</p>
                  @endif
                </div>
                <div class="col-md-2">
                  <button type="button" class="btn btn-success" id="addCCButton">Add</button>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-12">
                  <ul id="ccList" class="list-unstyled">
                    <!-- Dynamically added email addresses will appear here -->
                  </ul>
                </div>
              </div>
              <!-- Hidden input to store CC emails -->
              <input type="hidden" name="email_cc" id="email_cc_hidden">
            </div>
          </div>

        </div>
        <div class="modal-footer d-flex justify-content-between">
          <a href="{{ url()->previous() }}" style="width:120px;" class="btn btn-warning">
            Cancel
          </a>

          <button type="submit" style="width:120px;" class="btn btn-primary"
            onclick="return confirm('Apakah Anda yakin ingin menyimpan data ini ?')">
            Simpan
          </button>
        </div>

      </form>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    let choicesInstance = null;

    function initializeChoices() {
      const element = document.querySelector('.js-example-basic-multiple');

      if (choicesInstance) {
        choicesInstance.destroy(); // Destroy previous instance
      }

      choicesInstance = new Choices(element, {
        removeItemButton: true,
        shouldSort: false,
      });
    }

    function resetForm() {
      $('#notificationFields').find('input, textarea').val('');
      $('#notificationFields').find('select').each(function() {
        // Clear the selected items
        if (choicesInstance) {
          choicesInstance.clearStore();
        }
        $(this).val(null).trigger('change'); // Reset select element
      });
      $('#notificationFields').hide();
    }

    function toggleNotificationFields() {
      if ($('#enable_notification').is(':checked')) {
        $('#notificationFields').show();
        initializeChoices(); // Initialize Choices.js when showing fields
      } else {
        resetForm(); // Reset fields when hiding
      }
    }

    // Initialize Choices.js when modal is shown
    $('#modalupload').on('shown.bs.modal', function() {
      initializeChoices();
    });

    // Add change event listener to the radio buttons
    $('input[name="notification_radio"]').change(function() {
      toggleNotificationFields();
    });

    // Initialize on page load if needed
    toggleNotificationFields();
  });
</script>

<script>
  document.getElementById('addCCButton').addEventListener('click', function() {
    const ccInput = document.getElementById('addCC');
    const ccList = document.getElementById('ccList');
    const ccHiddenInput = document.getElementById('email_cc_hidden');

    const email = ccInput.value.trim();

    // Simple email validation
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (emailPattern.test(email)) {
      // Create a new list item with the email
      const li = document.createElement('li');
      li.textContent = email;
      li.classList.add('cc-item', 'd-flex',
        'justify-content-between',
        'align-items-center', 'my-2');

      // Add a remove button
      const removeButton = document.createElement('button');
      removeButton.textContent = 'X';
      removeButton.classList.add('btn', 'btn-danger', 'btn-sm', );
      removeButton.onclick = function() {
        ccList.removeChild(li);
        updateHiddenInput();
      };

      li.appendChild(removeButton);
      ccList.appendChild(li);
      ccInput.value = ''; // Clear the input field

      // Update the hidden input with the current list of emails
      updateHiddenInput();
    } else {
      emailError.style.display = 'block';
    }
  });

  function updateHiddenInput() {
    const ccItems = document.querySelectorAll('.cc-item');
    const ccEmails = Array.from(ccItems).map(item => item.firstChild.textContent);
    document.getElementById('email_cc_hidden').value = ccEmails.join(',');
  }
</script>


{{-- <script>
  document.getElementById('addCcButton').addEventListener('click', function() {
    const emailInput = document.getElementById('addCC');
    const emailValue = emailInput.value.trim();
    const emailError = document.getElementById('emailError');
    const ccList = document.getElementById('ccList');

    // Simple email validation
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (emailPattern.test(emailValue)) {
      emailError.style.display = 'none';

      // Create a new list item with the email and a remove button
      const listItem = document.createElement('li');
      listItem.className = "d-flex justify-content-between align-items-center my-2";
      listItem.innerHTML = `
                <span>${emailValue}</span>
                <button type="button" class="btn btn-danger btn-sm removeBtn">Remove</button>
            `;

      // Append the new list item to the ccList
      ccList.appendChild(listItem);

      // Clear the email input
      emailInput.value = '';
    } else {
      emailError.style.display = 'block';
    }
  });

  // Event delegation to handle the remove button click
  document.getElementById('ccList').addEventListener('click', function(event) {
    if (event.target.classList.contains('removeBtn')) {
      const listItem = event.target.parentElement;
      listItem.remove();
    }
  });
</script> --}}
