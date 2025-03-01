import type { FormEventHandler } from "react";

import { useForm } from "@inertiajs/react";

import AuthLayout from '@storefront/Layouts/AuthLayout';

type LoginForm = {
    email: string;
}

export default function AuthLogin() {
    const { data, setData, post, processing, errors, reset } = useForm<LoginForm>({
        email: '',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('storefront.auth.send-login-link'));
    };

    return (
        <AuthLayout>
            <h1>Login</h1>

            <form onSubmit={submit}>
                <input type="email" value={data.email} onChange={(e) => setData('email', e.target.value)} />
                {errors.email && <div>{errors.email}</div>}

                <button type="submit" disabled={processing}>Login</button>
            </form>
        </AuthLayout>
    );
}
