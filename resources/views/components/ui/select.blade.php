<div class="{{ $col }}">
    <div class="form-group">
        @if($label)
            <label class="form-control-label" for="{{ $name }}">
                {{ $label }}
                @if($required)<span class="small text-danger">*</span>@endif
            </label>
        @endif

        
        <select
            id="{{ $name }}"
            name="{{ $name }}"
            class="form-control @if($select2) select2 @endif @error($name) is-invalid @enderror"
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes }}
        >
            @if($nullable)
                <option value="">-- Please select --</option>
            @endif

            @if ($options)
                @foreach($options as $value => $text)
                    <option value="{{ $value }}" {{ $value == $selected ? 'selected' : '' }}>
                        {{ $text }}
                    </option>
                @endforeach
            @else
                <option value="1" {{ '1' == $selected ? 'selected' : '' }}>Active</option>
                <option value="0" {{ '0' == $selected ? 'selected' : '' }}>Inactive</option>
            @endif
        </select>

        @error($name)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
