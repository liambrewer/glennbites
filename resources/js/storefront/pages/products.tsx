import type { PageProps, Product } from '@storefront/types';

import { Head, useForm } from '@inertiajs/react';
import { useState } from 'react';
import { PlusIcon, StarIcon as StarIconSolid } from '@heroicons/react/24/solid';
import { StarIcon as StarIconOutline } from '@heroicons/react/24/outline';
import cn from '@storefront/utils/cn';

import AppLayout from '@storefront/layouts/app-layout';
import Button from '@storefront/components/ui/button';

interface Props {
    products: Product[];
}

export default function Products({ products }: PageProps & Props) {
    return (
        <>
            <Head title="Products" />

            <AppLayout>
                <ul className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    {products.map((product) => (
                        <ProductCard key={product.id} product={product} />
                    ))}
                </ul>
            </AppLayout>
        </>
    );
}

interface ProductCardProps {
    product: Product;
}

function ProductCard({ product }: ProductCardProps) {
    const [favorite, setFavorite] = useState<boolean>(false);

    function toggleFavorite() {
        setFavorite((prev) => !prev);
    }

    const { post } = useForm<{ product_id: number, quantity: number }>({
        product_id: product.id,
        quantity: 1,
    });

    function handleAddToCart() {
        post(route('storefront.cart.add'), {
            preserveScroll: true,
        });
    }

    return (
        <div className="flex flex-col bg-white border rounded-xl shadow-sm p-4 gap-2">
            <img src={product.image_url} alt="Product Image" className="max-w-full aspect-[16/9] object-cover rounded-lg border" />

            <div>
                <h1 className="text-base sm:text-lg font-semibold">{product.name}</h1>
                <p className="text-sm sm:text-base text-gray-600">{product.description ?? 'No description.'}</p>
            </div>

            <div className="grow"></div>

            <div className="flex gap-2 flex-wrap">
                <div className="bg-gray-100 px-2 py-0.5 rounded-full">
                    <span className="font-semibold">${product.price}</span> <span className="text-xs">each</span>
                </div>

                <div className="bg-green-500 text-white px-2 py-0.5 rounded-full">
                    <span className="font-semibold">{product.available_stock}</span> <span className="text-xs">available</span>
                </div>

                <div className="bg-gradient-to-r from-[#FFD700] to-[#EBB866] text-black px-2 py-0.5 rounded-full">
                    <span className="font-semibold">#1</span> <span className="text-xs">best seller</span>
                </div>
            </div>

            <div className="flex gap-2">
                <Button onClick={toggleFavorite}
                    className={cn({
                        "text-yellow-500": favorite,
                    })}
                    leftIcon={favorite ? <StarIconSolid /> : <StarIconOutline />}
                />

                <Button onClick={handleAddToCart} className="grow" variant="primary" leftIcon={<PlusIcon />}>
                    Add to Cart
                </Button>
            </div>
        </div>
    );
}
