import type { FormEventHandler, PropsWithChildren } from 'react';

import { Link, useForm, usePage } from '@inertiajs/react';
import { Bars3Icon } from '@heroicons/react/24/solid';

import Logo from '@storefront/components/logo';

export default function AppLayout({ children }: PropsWithChildren) {
    const {
        props: { auth },
    } = usePage();

    const { post } = useForm();

    const submitLogout: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('storefront.auth.logout'));
    };

    return (
        <div className="bg-gray-100">
            <div className="h-full min-h-lvh">
                <header className="bg-white border-b sticky top-0 z-10">
                    <div className="flex items-center h-12 container mx-auto px-4">
                        <Link href={route('storefront.home')} className="flex gap-2 items-center h-full">
                            <Logo className="size-8" />

                            <h1 className="text-2xl font-bold">Glennbites</h1>
                        </Link>

                        <div className="grow"></div>

                        <button className="size-8 p-1">
                            <Bars3Icon />
                        </button>
                    </div>
                </header>

                <main className="container mx-auto p-4">
                    {children}
                </main>
            </div>

            <footer className="bg-white border-t">
                Glennbites
            </footer>
        </div>
    );
}
