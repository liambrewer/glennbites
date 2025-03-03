import type { FormEventHandler, PropsWithChildren } from 'react';

import {useForm, usePage} from "@inertiajs/react";

export default function AppLayout({ children }: PropsWithChildren) {
    const { props: { auth } } = usePage();

    const { post } = useForm();

    const submitLogout: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('storefront.auth.logout'));
    }

    return (
        <>
            Hey, {auth.user.name}!

            <form onSubmit={submitLogout}>
                <button type="submit">Logout</button>
            </form>

            {children}
        </>
    );
}
