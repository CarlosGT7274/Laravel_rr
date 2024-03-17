<style>
    #{{ $id }}:checked~label>#{{ $id . '-radio' }} {
        border: 2px solid var(--color-primary);
    }

    #{{ $id }}:checked~label>#{{ $id . '-radio' }}>div {
        display: block;
    }

    #{{ $id }}[readonly]~label>#{{ $id . '-radio' }} {
        border: 2px solid var(--color-ldark);
    }

    #{{ $id }}[readonly]~label>#{{ $id . '-radio' }}>div {
        border: 2px solid var(--color-ldark);
        background-color: var(--color-ldark);
    }
</style>

<div class="flex flex-row justify-center items-center gap-2">

    <input @if ($readonly == 'yes') readonly @endif @if ($checked == 'yes' || old(strpos($name, '[') !== false ? str_replace(['[', ']'], ['.', ''], $name) : $name) === $value) checked @endif
        type="radio" id="{{ $id }}" name="{{ $name }}" value="{{ $value }}" hidden>

    <label
        class="{{ $readonly == '' ? 'flex flex-row items-center gap-4 cursor-pointer' : 'flex flex-row items-center gap-4' }}"
        for="{{ $id }}">

        <span id="{{ $id . '-radio' }}" class="w-[16px] h-[16px] border-2 border-ldark rounded-full">
            <div class="border-2 rounded-full bg-primary border-primary relative top-[2px] left-[2px] w-2 h-2 hidden">
            </div>
        </span>

        {{ $label }}

    </label>
</div>
