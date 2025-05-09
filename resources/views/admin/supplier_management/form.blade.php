<div class="mb-3">
    <label>Name</label>
    <input type="text" name="name" value="{{ old('name', $supplier->name ?? '') }}" class="form-control" required>
</div>
<div class="mb-3">
    <label>Contact Person</label>
    <input type="text" name="contact_person" value="{{ old('contact_person', $supplier->contact_person ?? '') }}" class="form-control">
</div>
<div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" value="{{ old('email', $supplier->email ?? '') }}" class="form-control">
</div>
<div class="mb-3">
    <label>Phone</label>
    <input type="text" name="phone" value="{{ old('phone', $supplier->phone ?? '') }}" class="form-control">
</div>
<div class="mb-3">
    <label>Address</label>
    <input type="text" name="address" value="{{ old('address', $supplier->address ?? '') }}" class="form-control">
</div>
