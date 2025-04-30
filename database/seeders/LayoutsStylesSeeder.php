<?php

namespace Database\Seeders;

use App\Models\LayoutStyle;
use Illuminate\Database\Seeder;

class LayoutsStylesSeeder extends Seeder
{
    public function run()
    {
        LayoutStyle::create(['id' => 1, 'name' => 'layout_style_vertical_light_sidebar', 'descricao' => 'Vertical - Barra Lateral Leve', 'ativo' => 0]);
        LayoutStyle::create(['id' => 2, 'name' => 'layout_style_vertical_compact_sidebar', 'descricao' => 'Vertical - Barra Lateral Compacta', 'ativo' => 0]);
        LayoutStyle::create(['id' => 3, 'name' => 'layout_style_vertical_icon_sidebar', 'descricao' => 'Vertical - Barra lateral de ícones', 'ativo' => 0]);
        LayoutStyle::create(['id' => 4, 'name' => 'layout_style_vertical_boxed_width', 'descricao' => 'Vertical - Largura da Caixa', 'ativo' => 0]);
        LayoutStyle::create(['id' => 5, 'name' => 'layout_style_vertical_colored_sidebar', 'descricao' => 'Vertical - Barra Lateral Colorida', 'ativo' => 0]);
        LayoutStyle::create(['id' => 6, 'name' => 'layout_style_vertical_scrollable', 'descricao' => 'Vertical - Rolável', 'ativo' => 1]);
        LayoutStyle::create(['id' => 7, 'name' => 'layout_style_horizontal_horizontal', 'descricao' => 'Horizontal - Horizontal', 'ativo' => 0]);
        LayoutStyle::create(['id' => 8, 'name' => 'layout_style_horizontal_topbar_light', 'descricao' => 'Horizontal - Luz da Barra Superior', 'ativo' => 0]);
        LayoutStyle::create(['id' => 9, 'name' => 'layout_style_horizontal_boxed_width', 'descricao' => 'Horizontal - Largura da Caixa', 'ativo' => 1]);
        LayoutStyle::create(['id' => 10, 'name' => 'layout_style_horizontal_colored_header', 'descricao' => 'Horizontal - Cabeçalho Colorido', 'ativo' => 0]);
        LayoutStyle::create(['id' => 11, 'name' => 'layout_style_horizontal_scrollable', 'descricao' => 'Horizontal - Rolável', 'ativo' => 0]);
    }
}
