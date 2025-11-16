<div class="{{ $col }}">
    <div class="form-group">
        @if($label)
            <label class="form-control-label" for="{{ $name }}">
                {{ $label }}
                @if($required)<span class="small text-danger">*</span>@endif
            </label>
        @endif
        
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            class="form-control @error($name) is-invalid @enderror"
            placeholder="{{ $placeholder }}"
            value="{{ $value }}"
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes }}
        >

        @error($name)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
