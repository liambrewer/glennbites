import { useState, type PropsWithChildren } from 'react';

import { Button, Layout } from 'antd'
import { MenuUnfoldOutlined, MenuFoldOutlined } from '@ant-design/icons';

import Logo from "@/Components/Logo";
import NavMenuList from "@/Components/NavMenuList";

export default function AppLayout({ children }: PropsWithChildren) {
    const [collapsed, setCollapsed] = useState(false);

    return (
        <Layout className='sidebar'>
            <Layout>
                <Layout.Sider collapsed={collapsed} collapsible trigger={null} className='sidebar'>
                    <Logo />
                    <NavMenuList />
                </Layout.Sider>
                <Layout>
                    <Layout.Header className='headerbar'>
                        <Button className='menuIcon' type='text' onClick={()=> setCollapsed(!collapsed)} icon={collapsed ? <MenuUnfoldOutlined /> : <MenuFoldOutlined />}/>
                        <h1 className='title'>Glennbites</h1>
                    </Layout.Header>
                    <Layout.Content className='contents'>
                        {children}
                    </Layout.Content>
                    <Layout.Footer  className='footerbar'>
                        &copy; {new Date().getFullYear()} Powered by glennbites.com
                    </Layout.Footer>
                </Layout>
            </Layout>
        </Layout>
    );
}
