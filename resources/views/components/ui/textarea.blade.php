<div class="{{ $col }}">
    <div class="form-group">
        @if($label)
            <label for="{{ $name }}" class="form-control-label">
                {{ $label }}
                @if($required)
                    <span class="small text-danger">*</span>
                @endif
            </label>
        @endif

        <textarea
            id="{{ $name }}"
            name="{{ $name }}"
            class="form-control @error($name) is-invalid @enderror"
            rows="{{ $rows }}"
            @if($required) required @endif
            @if($disabled) disabled @endif
        >{{ $value }}</textarea>
    </div>

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
