import Logo from '@storefront/Components/Logo';
import type { PropsWithChildren } from 'react';

interface AuthLayoutProps extends PropsWithChildren {
    title?: string;
    description?: string;
}

export default function AuthLayout({ title, description, children }: AuthLayoutProps) {
    return (
        <div className="flex h-full min-h-svh items-center justify-center bg-gray-100">
            <div className="flex w-full max-w-md flex-col gap-8 px-4 py-8 md:px-0">
                <Logo className="mx-auto" />

                <div className="space-y-2 text-center">
                    <h1 className="text-lg font-semibold">{title}</h1>
                    <p className="text-sm text-gray-600">{description}</p>
                </div>

                {children}
            </div>
        </div>
    );
}
