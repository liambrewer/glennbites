import type {Product} from "@/types";

import { Card } from "antd";
import { ShoppingCartOutlined, FireOutlined } from '@ant-design/icons'

interface Props {
    product: Product;
}

export default function ProductCard({ product }: Props) {
    return (
        <Card className='cards'
              hoverable
              style={{
                  width: 300
              }}
              cover={
                  <img height={180}
                       src={product.image_url}
                       alt="Product Image"
                  />
              }
              actions={[
                  <ShoppingCartOutlined key="shoppingCart" />,
                  <FireOutlined key="fire" />
              ]}
        >
            <Card.Meta className='meta'
                  title={product.name}
                  description={product.description ?? "No description."}

            />
        </Card>
    )
}
