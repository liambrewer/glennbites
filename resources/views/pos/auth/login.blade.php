<x-base-layout>
    <div class="fixed inset-0 flex flex-col gap-10 items-center justify-center">
        <h1 class="text-2xl font-semibold">Employee Login</h1>

        <form class="flex flex-col gap-5 max-w-lg w-full" action="{{ route('pos.auth.login') }}" method="post">
            @csrf

            <div class="w-full space-y-2.5">
                <x-ui.input.text label="Employee Number" name="employee_number" value="{{ old('employee_number') }}" required />
                <x-ui.input.text label="PIN" type="password" name="pin" required />
            </div>

            <x-ui.button.primary type="submit">Log in</x-ui.button.primary>
        </form>
    </div>
</x-base-layout>
