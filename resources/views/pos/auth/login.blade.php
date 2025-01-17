<x-pos-layout>
    <form action="{{ route('pos.auth.login') }}" method="post">
        @csrf

        <input type="text" name="employee_number" value="{{ old('employee_number') }}" />
        @error('employee_number') <p class="text-sm text-red-500 font-semibold">{{ $message }}</p> @enderror
        <input type="password" name="pin" value="{{ old('pin') }}" />
        @error('pin') <p class="text-sm text-red-500 font-semibold">{{ $message }}</p> @enderror

        <button type="submit">Log in</button>
    </form>
</x-pos-layout>
