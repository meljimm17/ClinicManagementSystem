<style>
    .ap-form-label { font-size: .68rem; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: #6b7f77; margin-bottom: 5px; display: block; }
    .ap-form-control { border: 1px solid #e4ece8; border-radius: 8px; padding: 9px 14px; font-size: .845rem; font-family: 'DM Sans', sans-serif; color: #1a2e25; background: #f4f7f5; width: 100%; outline: none; transition: border-color .15s; }
    .ap-form-control:focus { border-color: #3d8b6e; background: #fff; }
    .ap-input-invalid { border-color: #dc3545 !important; background: #fff5f5 !important; }
    .ap-section-label { font-size: .65rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: #2d7a50; padding: 6px 0 4px; border-bottom: 1px solid #e8f5f0; margin-bottom: 14px; display: block; }
    .ap-returning-toggle { display: flex; align-items: center; gap: 10px; background: #e8f5f0; border: 1px solid #c0dfd0; border-radius: 10px; padding: 10px 14px; margin-bottom: 18px; cursor: pointer; }
    .ap-returning-toggle input[type="checkbox"] { accent-color: #2d7a50; width: 15px; height: 15px; cursor: pointer; }
    .ap-returning-toggle label { font-size: .8rem; font-weight: 600; color: #2d7a50; cursor: pointer; margin: 0; }
    .ap-returning-toggle small { font-size: .7rem; color: #6b7f77; }
    #apReturningSearch { display: none; }
    #apReturningSearch.visible { display: block; }
    .ap-na-btn { display: inline-flex; align-items: center; gap: 4px; background: #f4f7f5; border: 1px solid #e4ece8; border-radius: 6px; padding: 2px 9px; font-size: .62rem; font-weight: 700; letter-spacing: .06em; color: #6b7f77; cursor: pointer; text-transform: uppercase; white-space: nowrap; }
    .ap-na-btn:hover, .ap-na-btn.active { background: #fff4e5; border-color: #f0d9a0; color: #b07000; }
    .ap-na-btn.active::before { content: '✓ '; }
</style>

<div class="modal fade" id="addPatientModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-person-plus me-2"></i>Add Patient</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('admin.patients.store') }}">
                    @csrf
                    <input type="hidden" name="returning_patient_id" id="ap_returning_patient_id" value="{{ old('returning_patient_id') }}">

                    {{-- ── Duplicate Patient Warning Banner ── --}}
                    <div id="apDuplicateWarningBanner" style="display:none; background:#fff8e1; border:1.5px solid #f6c90e; color:#7a5c00; border-radius:10px; padding:13px 16px; margin-bottom:16px; font-size:.82rem;">
                        <div style="display:flex; align-items:flex-start; gap:10px;">
                            <i class="bi bi-exclamation-triangle-fill" style="font-size:1.2rem; color:#e6a817; flex-shrink:0; margin-top:1px;"></i>
                            <div>
                                <div style="font-weight:700; font-size:.87rem; margin-bottom:3px;">⚠ Returning Patient Detected</div>
                                <div id="apDuplicateWarningText">This patient information matches an existing record. Would you like to load their details?</div>
                                <div style="margin-top:8px; display:flex; gap:8px; flex-wrap:wrap;">
                                    <button type="button" onclick="apLoadExistingPatient()" style="display:inline-flex; align-items:center; gap:5px; background:#1b3d2f; color:#fff; border-radius:6px; padding:5px 13px; font-size:.76rem; font-weight:700; cursor:pointer;">
                                        <i class="bi bi-check-circle"></i> Load Details
                                    </button>
                                    <button type="button" onclick="apDismissDuplicateWarning()" style="display:inline-flex; align-items:center; gap:5px; background:none; border:1.5px solid #c9a800; color:#7a5c00; border-radius:6px; padding:5px 13px; font-size:.76rem; font-weight:700; cursor:pointer;">
                                        <i class="bi bi-x-circle"></i> Continue Anyway
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <span class="ap-section-label">Personal Information</span>
                    <div class="mb-3">
                        <label class="ap-form-label">Full Patient Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="ap-form-control {{ $errors->has('name') ? 'ap-input-invalid' : '' }}" required>
                    </div>

                    <div class="row mb-3 g-2">
                        <div class="col-md-4">
                            <label class="ap-form-label">Date of Birth</label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="ap-form-control {{ $errors->has('date_of_birth') ? 'ap-input-invalid' : '' }}" id="ap_dob" onchange="apCalcAge()">
                        </div>
                        <div class="col-md-2">
                            <label class="ap-form-label">Age</label>
                            <input type="number" name="age" value="{{ old('age') }}" class="ap-form-control {{ $errors->has('age') ? 'ap-input-invalid' : '' }}" id="ap_age" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="ap-form-label">Gender</label>
                            <select name="gender" class="ap-form-control {{ $errors->has('gender') ? 'ap-input-invalid' : '' }}" required>
                                <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Select</option>
                                <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="ap-form-label">Civil Status</label>
                            <select name="civil_status" class="ap-form-control {{ $errors->has('civil_status') ? 'ap-input-invalid' : '' }}">
                                <option value="" {{ old('civil_status') ? '' : 'selected' }}>Select</option>
                                <option value="Single" {{ old('civil_status') === 'Single' ? 'selected' : '' }}>Single</option>
                                <option value="Married" {{ old('civil_status') === 'Married' ? 'selected' : '' }}>Married</option>
                                <option value="Widowed" {{ old('civil_status') === 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                <option value="Separated" {{ old('civil_status') === 'Separated' ? 'selected' : '' }}>Separated</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3 g-2">
                        <div class="col-md-6">
                            <label class="ap-form-label">Contact Number</label>
                            <input type="text" name="contact_number" value="{{ old('contact_number') }}" class="ap-form-control {{ $errors->has('contact_number') ? 'ap-input-invalid' : '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="ap-form-label">Address</label>
                            <input type="text" name="address" value="{{ old('address') }}" class="ap-form-control {{ $errors->has('address') ? 'ap-input-invalid' : '' }}" required>
                        </div>
                    </div>

                    <div class="row mb-4 g-2">
                        <div class="col-md-4"><label class="ap-form-label">Blood Type</label><input type="text" name="blood_type" value="{{ old('blood_type') }}" class="ap-form-control"></div>
                        <div class="col-md-4"><label class="ap-form-label">Height (cm)</label><input type="number" name="height" value="{{ old('height') }}" class="ap-form-control"></div>
                        <div class="col-md-4"><label class="ap-form-label">Weight (kg)</label><input type="number" name="weight" value="{{ old('weight') }}" class="ap-form-control"></div>
                    </div>

                    <span class="ap-section-label">Administrative Details</span>
                    <div class="row mb-3 g-2">
                        <div class="col-md-6"><label class="ap-form-label">PhilHealth No.</label><input type="text" name="philhealth_no" value="{{ old('philhealth_no') }}" id="ap_philhealth" class="ap-form-control"></div>
                        <div class="col-md-6"><label class="ap-form-label">HMO / Insurance</label><input type="text" name="hmo_insurance" value="{{ old('hmo_insurance') }}" id="ap_hmo" class="ap-form-control"></div>
                    </div>
                    <div class="row mb-4 g-2">
                        <div class="col-md-6"><label class="ap-form-label">Emergency Contact Name</label><input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}" id="ap_emgName" class="ap-form-control"></div>
                        <div class="col-md-6"><label class="ap-form-label">Emergency Contact Number</label><input type="text" name="emergency_contact_number" value="{{ old('emergency_contact_number') }}" id="ap_emgContact" class="ap-form-control"></div>
                    </div>

                    <span class="ap-section-label">Medical History</span>
                    <div class="mb-3"><label class="ap-form-label">Known Allergies</label><input type="text" name="known_allergies" value="{{ old('known_allergies') }}" id="ap_allergies" class="ap-form-control"></div>
                    <div class="mb-3"><label class="ap-form-label">Existing Conditions</label><input type="text" name="existing_conditions" value="{{ old('existing_conditions') }}" id="ap_conditions" class="ap-form-control"></div>
                    <div class="mb-4"><label class="ap-form-label">Current Medications</label><input type="text" name="current_medications" value="{{ old('current_medications') }}" id="ap_medications" class="ap-form-control"></div>

                    <span class="ap-section-label">Visit Information</span>
                    <div class="mb-3">
                        <label class="ap-form-label">Primary Symptoms</label>
                        <textarea name="primary_symptoms" class="ap-form-control {{ $errors->has('primary_symptoms') ? 'ap-input-invalid' : '' }}" rows="3" required>{{ old('primary_symptoms') }}</textarea>
                    </div>
                    <div class="ap-returning-toggle mb-3" onclick="apTogglePriority(this)">
                        <input type="checkbox" id="apPriorityCheck" name="is_priority" value="1" {{ old('is_priority') ? 'checked' : '' }}>
                        <div>
                            <label for="apPriorityCheck">Mark as Priority Patient?</label><br>
                            <small>Senior, PWD, pregnant, urgent, etc.</small>
                        </div>
                    </div>
                    <div id="apPriorityFields" style="display: {{ old('is_priority') ? 'block' : 'none' }};">
                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label class="ap-form-label">Priority Type</label>
                                <select name="priority_type" class="ap-form-control {{ $errors->has('priority_type') ? 'ap-input-invalid' : '' }}">
                                    <option value="">Select priority type</option>
                                    <option value="senior" {{ old('priority_type') === 'senior' ? 'selected' : '' }}>Senior Citizen</option>
                                    <option value="pwd" {{ old('priority_type') === 'pwd' ? 'selected' : '' }}>PWD</option>
                                    <option value="pregnant" {{ old('priority_type') === 'pregnant' ? 'selected' : '' }}>Pregnant</option>
                                    <option value="urgent" {{ old('priority_type') === 'urgent' ? 'selected' : '' }}>Urgent Case</option>
                                    <option value="other" {{ old('priority_type') === 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="ap-form-label">Priority Notes</label>
                                <input type="text" name="priority_notes" value="{{ old('priority_notes') }}" class="ap-form-control" placeholder="Optional note">
                            </div>
                        </div>
                    </div>

                    <span class="ap-section-label">Check-up Type & Billing</span>
                    <div class="row mb-3 g-2">
                        <div class="col-md-6">
                            <label class="ap-form-label">Select Check-up Type</label>
                            <select name="checkup_type_id" id="apCheckupTypeSelect" class="ap-form-control {{ $errors->has('checkup_type_id') ? 'ap-input-invalid' : '' }}" style="appearance:auto;" onchange="apUpdateFeeDisplay()">
                                <option value="">-- Select Type --</option>
                                @forelse($checkupTypes ?? [] as $type)
                                    <option value="{{ $type->id }}" data-fee="{{ $type->fee }}" {{ old('checkup_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }} - ₱{{ number_format($type->fee, 2) }}
                                    </option>
                                @empty
                                    <option value="">No check-up types available</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="ap-form-label">Or Custom Fee (Override)</label>
                            <input type="number" name="custom_fee" id="apCustomFee" value="{{ old('custom_fee') }}" class="ap-form-control {{ $errors->has('custom_fee') ? 'ap-input-invalid' : '' }}" placeholder="0.00" step="0.01" min="0" onchange="apToggleCustomFee()">
                        </div>
                    </div>
                    <div id="apFeeDisplay" class="mb-3" style="font-size: .8rem; color: #6b7f77;">
                        <i class="bi bi-info-circle me-1"></i> Fee will be automatically assigned based on check-up type
                    </div>

                    <button type="submit" class="btn btn-success w-100"><i class="bi bi-person-check me-2"></i>Complete Registration</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function apCalcAge() {
        const dob = document.getElementById('ap_dob').value;
        if (!dob) return;
        const today = new Date();
        const birth = new Date(dob);
        let age = today.getFullYear() - birth.getFullYear();
        const m = today.getMonth() - birth.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) age--;
        document.getElementById('ap_age').value = age;
    }

    function apToggleReturning(wrapper) {
        const cb = wrapper.querySelector('input[type="checkbox"]');
        cb.checked = !cb.checked;
        document.getElementById('apReturningSearch').classList.toggle('visible', cb.checked);
    }

    function apTogglePriority(wrapper) {
        const cb = wrapper.querySelector('input[type="checkbox"]');
        cb.checked = !cb.checked;
        document.getElementById('apPriorityFields').style.display = cb.checked ? 'block' : 'none';
    }

    /* ── Automatic Returning Patient Detection ── */
    let _apDuplicateWarningDismissed = false;
    let _apDuplicateCheckTimeout = null;
    let _apDetectedPatient = null;

    function apCheckDuplicatePatient() {
        if (_apDuplicateWarningDismissed) return;
        
        const name = (document.querySelector('#addPatientModal [name="name"]')?.value ?? '').trim();
        const dob = (document.querySelector('#addPatientModal [name="date_of_birth"]')?.value ?? '').trim();
        const address = (document.querySelector('#addPatientModal [name="address"]')?.value ?? '').trim();
        const contact = (document.querySelector('#addPatientModal [name="contact_number"]')?.value ?? '').trim();
        
        clearTimeout(_apDuplicateCheckTimeout);
        _apDuplicateCheckTimeout = setTimeout(() => {
            if (name.length < 2 || !dob || (address.length < 5 && contact.length < 7)) return;
            
            fetch(`{{ route('patients.check-existence') }}?` + new URLSearchParams({
                name, date_of_birth: dob, address, contact_number: contact
            }))
            .then(res => res.json())
            .then(data => {
                if (data.exists && data.patient) {
                    _apDetectedPatient = data.patient;
                    document.getElementById('apDuplicateWarningBanner').style.display = 'block';
                    document.getElementById('apDuplicateWarningText').innerHTML = 
                        `Patient <strong>${data.patient.name}</strong> with matching information found. Would you like to load their details?`;
                } else {
                    document.getElementById('apDuplicateWarningBanner').style.display = 'none';
                    _apDetectedPatient = null;
                }
            })
            .catch(err => console.error('Duplicate check failed:', err));
        }, 800); // Debounce for 800ms
    }

    function apLoadExistingPatient() {
        if (!_apDetectedPatient) return;
        
        const p = _apDetectedPatient;
        document.querySelector('#addPatientModal [name="name"]').value = p.name ?? '';
        document.querySelector('#addPatientModal [name="date_of_birth"]').value = p.date_of_birth ?? '';
        document.querySelector('#addPatientModal [name="age"]').value = p.age ?? '';
        document.querySelector('#addPatientModal [name="gender"]').value = p.gender ?? '';
        document.querySelector('#addPatientModal [name="civil_status"]').value = p.civil_status ?? '';
        document.querySelector('#addPatientModal [name="contact_number"]').value = p.contact_number ?? '';
        document.querySelector('#addPatientModal [name="address"]').value = p.address ?? '';
        document.querySelector('#addPatientModal [name="blood_type"]').value = p.blood_type ?? '';
        document.querySelector('#addPatientModal [name="height"]').value = p.height ?? '';
        document.querySelector('#addPatientModal [name="weight"]').value = p.weight ?? '';
        document.querySelector('#addPatientModal [name="philhealth_no"]').value = p.philhealth_no ?? '';
        document.querySelector('#addPatientModal [name="hmo_insurance"]').value = p.hmo_insurance ?? '';
        document.getElementById('ap_emgName').value = p.emergency_contact_name ?? '';
        document.getElementById('ap_emgContact').value = p.emergency_contact_number ?? '';
        document.getElementById('ap_allergies').value = p.known_allergies ?? '';
        document.getElementById('ap_conditions').value = p.existing_conditions ?? '';
        document.getElementById('ap_medications').value = p.current_medications ?? '';
        
        document.getElementById('apDuplicateWarningBanner').style.display = 'none';
        _apDuplicateWarningDismissed = true;
    }

    function apDismissDuplicateWarning() {
        document.getElementById('apDuplicateWarningBanner').style.display = 'none';
        _apDuplicateWarningDismissed = true;
    }

    /* Update fee display when checkup type changes */
    function apUpdateFeeDisplay() {
        const select = document.getElementById('apCheckupTypeSelect');
        const customFee = document.getElementById('apCustomFee');
        const display = document.getElementById('apFeeDisplay');
        
        if (select.selectedOptions.length > 0) {
            const option = select.selectedOptions[0];
            const fee = option.getAttribute('data-fee');
            if (fee && !customFee.value) {
                display.innerHTML = '<i class="bi bi-info-circle me-1"></i> Selected: <strong>₱' + parseFloat(fee).toFixed(2) + '</strong>';
            } else if (customFee.value) {
                display.innerHTML = '<i class="bi bi-info-circle me-1"></i> Custom fee override: <strong>₱' + parseFloat(customFee.value).toFixed(2) + '</strong>';
            } else {
                display.innerHTML = '<i class="bi bi-info-circle me-1"></i> Fee will be automatically assigned based on check-up type';
            }
        }
    }

    /* Toggle custom fee when manually entered */
    function apToggleCustomFee() {
        const customFee = document.getElementById('apCustomFee');
        const select = document.getElementById('apCheckupTypeSelect');
        const display = document.getElementById('apFeeDisplay');
        
        if (customFee.value && parseFloat(customFee.value) > 0) {
            select.value = ''; // Clear checkup type when using custom fee
            display.innerHTML = '<i class="bi bi-info-circle me-1"></i> Custom fee override: <strong>₱' + parseFloat(customFee.value).toFixed(2) + '</strong>';
        } else {
            apUpdateFeeDisplay();
        }
    }

    function apFillPatient(p) {
        document.getElementById('apSearchResults').style.display = 'none';
        document.getElementById('apPatientSearchInput').value = p.name;
        document.getElementById('ap_returning_patient_id').value = p.id ?? '';
        document.querySelector('#addPatientModal [name="name"]').value = p.name ?? '';
        document.querySelector('#addPatientModal [name="date_of_birth"]').value = p.date_of_birth ?? '';
        document.querySelector('#addPatientModal [name="age"]').value = p.age ?? '';
        document.querySelector('#addPatientModal [name="gender"]').value = p.gender ?? '';
        document.querySelector('#addPatientModal [name="civil_status"]').value = p.civil_status ?? '';
        document.querySelector('#addPatientModal [name="contact_number"]').value = p.contact_number ?? '';
        document.querySelector('#addPatientModal [name="address"]').value = p.address ?? '';
        document.querySelector('#addPatientModal [name="blood_type"]').value = p.blood_type ?? '';
        document.querySelector('#addPatientModal [name="height"]').value = p.height ?? '';
        document.querySelector('#addPatientModal [name="weight"]').value = p.weight ?? '';
        document.querySelector('#addPatientModal [name="philhealth_no"]').value = p.philhealth_no ?? '';
        document.querySelector('#addPatientModal [name="hmo_insurance"]').value = p.hmo_insurance ?? '';
        document.getElementById('ap_emgName').value = p.emergency_contact_name ?? '';
        document.getElementById('ap_emgContact').value = p.emergency_contact_number ?? '';
        document.getElementById('ap_allergies').value = p.known_allergies ?? '';
        document.getElementById('ap_conditions').value = p.existing_conditions ?? '';
        document.getElementById('ap_medications').value = p.current_medications ?? '';
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Add event listeners for automatic duplicate detection
        const nameField = document.querySelector('#addPatientModal [name="name"]');
        const dobField = document.querySelector('#addPatientModal [name="date_of_birth"]');
        const addressField = document.querySelector('#addPatientModal [name="address"]');
        const contactField = document.querySelector('#addPatientModal [name="contact_number"]');
        
        if (nameField) nameField.addEventListener('input', apCheckDuplicatePatient);
        if (dobField) dobField.addEventListener('input', apCheckDuplicatePatient);
        if (addressField) addressField.addEventListener('input', apCheckDuplicatePatient);
        if (contactField) contactField.addEventListener('input', apCheckDuplicatePatient);

        @if($errors->has('name') || $errors->has('primary_symptoms') || $errors->has('contact_number'))
            const modal = new bootstrap.Modal(document.getElementById('addPatientModal'));
            modal.show();
        @endif

        @if(old('checkup_type_id') || old('custom_fee'))
            apUpdateFeeDisplay();
        @endif
    });
</script>
