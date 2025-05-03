<!-- resources/views/admin/users/_form.blade.php -->

{{-- Nombre --}}
<div class="mb-3">
  <label class="form-label">Nombre</label>
  <input name="name"
         value="{{ $get('name') }}"
         class="form-control">
  @error('name') <div class="text-danger">{{ $message }}</div> @enderror
</div>

{{-- Email --}}
<div class="mb-3">
  <label class="form-label">Email</label>
  <input name="email"
         type="email"
         value="{{ $get('email') }}"
         class="form-control">
  @error('email') <div class="text-danger">{{ $message }}</div> @enderror
</div>

{{-- Contraseña --}}
<div class="mb-3">
  <label class="form-label">
      Contraseña
      @if(request()->routeIs('admin.users.edit'))
          <small>(opcional)</small>
      @endif
  </label>
  <input name="password" type="password" class="form-control">
  @error('password') <div class="text-danger">{{ $message }}</div> @enderror
</div>

{{-- Confirmación --}}
<div class="mb-3">
  <label class="form-label">Confirmar Contraseña</label>
  <input name="password_confirmation" type="password" class="form-control">
</div>

{{-- Rol --}}
<div class="mb-3">
  <label class="form-label">Rol</label>
  <select name="role_id" class="form-select">
      <option value="">-- Selecciona --</option>
      @foreach($roles as $id => $label)
          <option value="{{ $id }}"
              {{ $get('role_id') == $id ? 'selected' : '' }}>
              {{ $label }}
          </option>
      @endforeach
  </select>
  @error('role_id') <div class="text-danger">{{ $message }}</div> @enderror
</div>

{{-- Activo --}}
<div class="form-check mb-3">
  <input type="checkbox"
         name="is_active"
         value="1"
         class="form-check-input"
         {{ $get('is_active') ? 'checked' : '' }}>
  <label class="form-check-label">Activo</label>
</div>
