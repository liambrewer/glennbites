import type { ButtonHTMLAttributes, PropsWithChildren, ReactNode } from 'react';

import cn from '@storefront/utils/cn';

interface ButtonProps extends ButtonHTMLAttributes<HTMLButtonElement> {
    variant?: 'primary' | 'success' | 'danger';
    leftIcon?: ReactNode;
    rightIcon?: ReactNode;
}

export default function Button({ variant, children, className, leftIcon, rightIcon, ...buttonProps }: PropsWithChildren<ButtonProps>) {
    return (
        <button
            className={cn(
                [
                    'flex select-none items-center justify-center gap-2 rounded-lg px-4 py-2 text-sm font-medium text-gray-800 outline-none duration-150',
                    'hover:bg-gray-100 focus:bg-gray-100 focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 active:bg-gray-200',
                    'disabled:pointer-events-none disabled:opacity-50',
                ],
                {
                    'bg-blue-500 text-white hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700': variant === 'primary',
                    'bg-green-500 text-white hover:bg-green-600 focus:bg-green-600 focus:ring-green-500 active:bg-green-700': variant === 'success',
                    'bg-red-500 text-white hover:bg-red-600 focus:bg-red-600 focus:ring-red-500 active:bg-red-700': variant === 'danger',
                },
                className,
            )}
            {...buttonProps}
        >
            {leftIcon && <Icon icon={leftIcon} />}
            {children}
            {rightIcon && <Icon icon={rightIcon} />}
        </button>
    );
}

function Icon({ icon, className }: { icon: ReactNode; className?: string }) {
    return <div className={cn('size-5 flex-shrink-0', className)}>{icon}</div>;
}
