<template>
    <Row>
        <Col span="8">
            <Menu :open-names="[]" accordion>
                <Submenu name="1">
                    <template slot="title">
                        <Icon type="ios-paper" />
                        内容管理
                    </template>
                    <MenuItem name="1-1">文章管理</MenuItem>
                    <MenuItem name="1-2">评论管理</MenuItem>
                    <MenuItem name="1-3">举报管理</MenuItem>
                </Submenu>
            </Menu>
        </Col>
    </Row>
</template>
<script>
    export default {
        data () {
            return {
               
            }
        }
    }
</script>
