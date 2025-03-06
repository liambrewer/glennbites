import { Link } from '@inertiajs/react';

import { HomeOutlined, PhoneOutlined, SettingOutlined, ShoppingCartOutlined, UserOutlined } from '@ant-design/icons';
import { Menu } from 'antd';

export default function NavMenuList() {
    return (
        <Menu theme="dark" mode="inline" className="menu-bar">
            <Menu.Item className="homeIcon" key="Home" icon={<HomeOutlined />}>
                <Link className="menuName" href="/public">
                    Home
                </Link>
            </Menu.Item>

            <Menu.Item className="productsIcon" key="Products" icon={<ShoppingCartOutlined />}>
                <Link className="menuName" href="/products">
                    Products
                </Link>
            </Menu.Item>

            <Menu.Item className="supportIcon" key="Support" icon={<PhoneOutlined />}>
                <Link className="menuName" href="/support">
                    Support
                </Link>
            </Menu.Item>

            <Menu.Item className="signInIcon" key="Sign in" icon={<UserOutlined />}>
                <Link className="menuName" href="/signIn">
                    Sign in
                </Link>
            </Menu.Item>

            <Menu.Item className="settingsIcon" key="Settings" icon={<SettingOutlined />}>
                <Link className="menuName" href="/settings">
                    Settings
                </Link>
            </Menu.Item>
        </Menu>
    );
}
