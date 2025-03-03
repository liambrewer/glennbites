import type { ButtonHTMLAttributes, PropsWithChildren, ReactNode } from "react";

import clsx from "clsx";
import cn from "@storefront/Utils/cn";

interface ButtonProps extends ButtonHTMLAttributes<HTMLButtonElement> {
    variant?: 'primary' | 'success' | 'danger';
    leftIcon?: ReactNode;
    rightIcon?: ReactNode;
}

export default function Button({
    variant,
    children,
    className,
    leftIcon,
    rightIcon,
    ...buttonProps
}: PropsWithChildren<ButtonProps>) {
    return (
        <button
            className={cn(
                [
                    "flex items-center justify-center gap-2 px-4 py-2 rounded-lg text-sm text-gray-800 font-medium select-none outline-none duration-150",
                    "hover:bg-gray-100 focus:bg-gray-100 focus:ring-2 focus:ring-offset-1 focus:ring-blue-500 active:bg-gray-200",
                    "disabled:opacity-50 disabled:pointer-events-none",
                ],
                {
                    "bg-blue-500 text-white hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700": variant === 'primary',
                    "bg-green-500 text-white hover:bg-green-600 focus:bg-green-600 active:bg-green-700 focus:ring-green-500": variant === 'success',
                    "bg-red-500 text-white hover:bg-red-600 focus:bg-red-600 active:bg-red-700 focus:ring-red-500": variant === 'danger',
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
    return (
        <div className={cn("size-5 flex-shrink-0", className)}>
            {icon}
        </div>
    )
}
