import type { PageProps, Product } from '@storefront/types';

import AppLayout from '@storefront/layouts/app-layout';
import Button from '@storefront/components/ui/button';
import { router } from '@inertiajs/react';
import { useState } from 'react';

const axios = window.axios;

interface ICartItem {
    product: Product,
    quantity: number,
    price: number,
    error?: string,
}

interface CartProps extends PageProps {
    items: ICartItem[],
    total: number,
    valid: boolean,
}

export default function Cart({ items, total, valid }: CartProps) {
    return (
        <AppLayout>
            <h1 className="text-xl font-semibold mb-4">Cart</h1>

            <div className="grid lg:grid-cols-3 gap-4">
                <ul className="flex flex-col gap-4 lg:col-span-2">
                    {items.map((item) => (
                        <CartItem key={item.product.id} item={item} />
                    ))}
                </ul>

                <div className="bg-white border p-4 rounded-xl">
                    <h3>Total</h3>
                    <p>${total.toFixed(2)}</p>

                    <Button
                        variant="primary"
                        // href={route('storefront.checkout')}
                        disabled={!valid}
                    >
                        Checkout
                    </Button>
                </div>
            </div>

        </AppLayout>
    );
}

interface CartItemProps {
    item: ICartItem;
}

function CartItem({ item }: CartItemProps) {
    async function increment() {
        await axios.post(route('storefront.cart.add'), {
            product_id: item.product.id,
            quantity: 1,
        });

        reloadCart();
    }

    async function decrement() {
        await axios.post(route('storefront.cart.remove'), {
            product_id: item.product.id,
            quantity: 1,
        });

        reloadCart();
    }

    async function remove() {
        await axios.post(route('storefront.cart.delete'), {
            product_id: item.product.id,
        });

        reloadCart();
    }

    return (
        <li className="bg-white border p-4 rounded-xl">
            <h3>{item.product.name}</h3>
            <p>Quantity: {item.quantity}</p>
            <p>Price: ${item.price.toFixed(2)}</p>
            {item.error && <p>{item.error}</p>}
            <div>
                <Button onClick={increment}>+</Button>
                <Button onClick={decrement}>-</Button>
                <Button onClick={remove}>Remove</Button>
            </div>
        </li>
    );
}

function reloadCart() {
    router.visit(route('storefront.cart.index'), {
        preserveScroll: true,
        only: ['items', 'total', 'valid'],
    });
}
