<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* @gantry-admin/ajax/fontpicker.html.twig */
class __TwigTemplate_ef63b540d0ad073e81ca8cd4c47b7db5 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<div id=\"g-fonts\" class=\"g-grid\">
    <div class=\"g-particles-header settings-block\">
        <input class=\"float-left font-preview\" type=\"text\" data-font-preview=\"\" placeholder=\"";
        // line 3
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_FONTS_PREVIEW"), "html", null, true);
        echo "\"
               value=\"";
        // line 4
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_FONTS_SAMPLE"), "html", null, true);
        echo "\">
        <span class=\"float-right particle-search-wrapper\">
            <input class=\"font-search\" type=\"text\" data-font-search=\"\" placeholder=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_SEARCH_FONT_ELI"), "html", null, true);
        echo "\">
            <span class=\"particle-search-total\">";
        // line 7
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["fonts"] ?? null), "count", [], "any", false, false, false, 7), "html", null, true);
        echo "</span>
        </span>
    </div>
    <div class=\"g-particles-main\">
        <ul class=\"g-fonts-list\">
            ";
        // line 12
        if (twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["fonts"] ?? null), "local_families", [], "any", false, false, false, 12))) {
            // line 13
            echo "                <li class=\"g-font-heading\">";
            echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_FONTS_LOCAL"), "html", null, true);
            echo "</li>
            ";
            // line 14
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["fonts"] ?? null), "local_families", [], "any", false, false, false, 14));
            foreach ($context['_seq'] as $context["_key"] => $context["font"]) {
                // line 15
                echo "                <li class=\"g-local-font\" data-font=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["font"], "family", [], "any", false, false, false, 15), "html", null, true);
                echo "\" data-variant data-variants=\"";
                echo twig_escape_filter($this->env, twig_join_filter(twig_get_attribute($this->env, $this->source, $context["font"], "variants", [], "any", false, false, false, 15), ","), "html", null, true);
                echo "\"
                    data-subsets=\"";
                // line 16
                echo twig_escape_filter($this->env, twig_join_filter(twig_get_attribute($this->env, $this->source, $context["font"], "subsets", [], "any", false, false, false, 16), ","), "html", null, true);
                echo "\" data-category=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["font"], "category", [], "any", false, false, false, 16), "html", null, true);
                echo "\">
                    <input type=\"checkbox\" value=\"";
                // line 17
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["font"], "family", [], "any", false, false, false, 17), "html", null, true);
                echo "\" />
                    <div class=\"family\">
                        <strong>";
                // line 19
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["font"], "family", [], "any", false, false, false, 19), "html", null, true);
                echo "</strong>,
                        <span class=\"g-font-variants-list\">
                            ";
                // line 21
                if ((twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, $context["font"], "variants", [], "any", false, false, false, 21)) > 1)) {
                    // line 22
                    echo "                                ";
                    echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_FONTS_X_STYLES", twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, $context["font"], "variants", [], "any", false, false, false, 22))), "html", null, true);
                    echo "
                            ";
                } else {
                    // line 24
                    echo "                                ";
                    echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_FONTS_X_STYLE", twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, $context["font"], "variants", [], "any", false, false, false, 24))), "html", null, true);
                    echo "
                            ";
                }
                // line 26
                echo "                        </span>
                    </div>
                </li>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['font'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 30
            echo "                <li class=\"g-font-heading\">";
            echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_FONTS_REMOTE"), "html", null, true);
            echo "</li>
            ";
        }
        // line 32
        echo "            ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["fonts"] ?? null), "families", [], "any", false, false, false, 32));
        foreach ($context['_seq'] as $context["_key"] => $context["font"]) {
            // line 33
            echo "                <li data-font=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["font"], "family", [], "any", false, false, false, 33), "html", null, true);
            echo "\" data-variant=\"";
            echo twig_escape_filter($this->env, twig_first($this->env, twig_get_attribute($this->env, $this->source, $context["font"], "variants", [], "any", false, false, false, 33)), "html", null, true);
            echo "\"
                    data-variants=\"";
            // line 34
            echo twig_escape_filter($this->env, twig_replace_filter(twig_join_filter(twig_get_attribute($this->env, $this->source, $context["font"], "variants", [], "any", false, false, false, 34), ","), ["regular" => "normal"]), "html", null, true);
            echo "\"
                    data-subsets=\"";
            // line 35
            echo twig_escape_filter($this->env, twig_join_filter(twig_get_attribute($this->env, $this->source, $context["font"], "subsets", [], "any", false, false, false, 35), ","), "html", null, true);
            echo "\" data-category=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["font"], "category", [], "any", false, false, false, 35), "html", null, true);
            echo "\">
                    <div class=\"family\">
                        <strong>";
            // line 37
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["font"], "family", [], "any", false, false, false, 37), "html", null, true);
            echo "</strong>,
                        ";
            // line 38
            if ((twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, $context["font"], "variants", [], "any", false, false, false, 38)) > 1)) {
                // line 39
                echo "                            ";
                echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_FONTS_X_STYLES", twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, $context["font"], "variants", [], "any", false, false, false, 39))), "html", null, true);
                echo "
                        ";
            } else {
                // line 41
                echo "                            ";
                echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_FONTS_X_STYLE", twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, $context["font"], "variants", [], "any", false, false, false, 41))), "html", null, true);
                echo "
                        ";
            }
            // line 43
            if ((twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, $context["font"], "subsets", [], "any", false, false, false, 43)) > 1)) {
                // line 44
                echo ", <span class=\"font-charsets\">";
                echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_FONTS_X_CHARSETS", twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, $context["font"], "subsets", [], "any", false, false, false, 44))), "html", null, true);
                echo "
                            <span class=\"font-charsets-selected\">(<i class=\"far fa-fw fa-check-square\" aria-hidden=\"true\"></i>
                                <span class=\"font-charsets-details\">";
                // line 46
                echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_FONTS_X_OF_Y", 1, twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, $context["font"], "subsets", [], "any", false, false, false, 46))), "html", null, true);
                echo "</span>
                                ";
                // line 47
                echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_FONTS_SELECTED"), "html", null, true);
                echo ")
                            </span>
                        </span>
                        ";
            }
            // line 51
            echo "                    </div>
                    <ul>
                        ";
            // line 53
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["font"], "variants", [], "any", false, false, false, 53));
            foreach ($context['_seq'] as $context["_key"] => $context["variant"]) {
                // line 54
                echo "                            <li data-font=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["font"], "family", [], "any", false, false, false, 54), "html", null, true);
                echo "\" data-variant=\"";
                echo twig_escape_filter($this->env, $context["variant"], "html", null, true);
                echo "\"";
                if (($context["variant"] != twig_first($this->env, twig_get_attribute($this->env, $this->source, $context["font"], "variants", [], "any", false, false, false, 54)))) {
                    // line 55
                    echo "                                class=\"g-variant-hide\"";
                }
                echo ">
                                <input type=\"checkbox\" value=\"";
                // line 56
                echo twig_escape_filter($this->env, $context["variant"], "html", null, true);
                echo "\" />
                                <div class=\"variant\"><small>";
                // line 57
                echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, ($context["variantsMap"] ?? null), $context["variant"], [], "array", true, true, false, 57)) ? (_twig_default_filter((($__internal_compile_0 = ($context["variantsMap"] ?? null)) && is_array($__internal_compile_0) || $__internal_compile_0 instanceof ArrayAccess ? ($__internal_compile_0[$context["variant"]] ?? null) : null), $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_FONTS_UNKNOWN_VARIANT"))) : ($this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_FONTS_UNKNOWN_VARIANT"))), "html", null, true);
                echo "</small></div>
                                <div class=\"preview\">";
                // line 58
                echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_FONTS_SAMPLE"), "html", null, true);
                echo "</div>
                            </li>
                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['variant'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 61
            echo "                    </ul>
                </li>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['font'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 64
        echo "        </ul>
    </div>
    <div class=\"g-particles-footer settings-block\">
        <div class=\"float-left font-left-container\">
            <span class=\"button font-category\" data-font-categories=\"";
        // line 68
        echo twig_escape_filter($this->env, twig_join_filter(twig_get_attribute($this->env, $this->source, ($context["fonts"] ?? null), "categories", [], "any", false, false, false, 68), ","), "html", null, true);
        echo "\">
                ";
        // line 69
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_CATEGORIES"), "html", null, true);
        echo " (<small>";
        echo twig_escape_filter($this->env, twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["fonts"] ?? null), "categories", [], "any", false, false, false, 69)), "html", null, true);
        echo "</small>) <i class=\"fa fa-caret-down\" aria-hidden=\"true\"></i>
            </span>
            <span class=\"button font-subsets\" data-font-subsets=\"";
        // line 71
        echo twig_escape_filter($this->env, twig_join_filter(twig_get_attribute($this->env, $this->source, ($context["fonts"] ?? null), "subsets", [], "any", false, false, false, 71), ","), "html", null, true);
        echo "\">
                ";
        // line 72
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_SUBSETS"), "html", null, true);
        echo " (<small>";
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_LATIN"), "html", null, true);
        echo "</small>) <i class=\"fa fa-caret-down\" aria-hidden=\"true\"></i>
            </span>
        </div>
        <div class=\"float-right font-right-container\">
            <span class=\"font-selected\"></span>
            <button class=\"button button-primary\">";
        // line 77
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_SELECT"), "html", null, true);
        echo "</button>
            <span>&nbsp;</span>
            <button class=\"button g5-dialog-close\">";
        // line 79
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_CANCEL"), "html", null, true);
        echo "</button>
        </div>
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "@gantry-admin/ajax/fontpicker.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  266 => 79,  261 => 77,  251 => 72,  247 => 71,  240 => 69,  236 => 68,  230 => 64,  222 => 61,  213 => 58,  209 => 57,  205 => 56,  200 => 55,  193 => 54,  189 => 53,  185 => 51,  178 => 47,  174 => 46,  168 => 44,  166 => 43,  160 => 41,  154 => 39,  152 => 38,  148 => 37,  141 => 35,  137 => 34,  130 => 33,  125 => 32,  119 => 30,  110 => 26,  104 => 24,  98 => 22,  96 => 21,  91 => 19,  86 => 17,  80 => 16,  73 => 15,  69 => 14,  64 => 13,  62 => 12,  54 => 7,  50 => 6,  45 => 4,  41 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@gantry-admin/ajax/fontpicker.html.twig", "C:\\MAMP\\htdocs\\cassava.nri.org\\administrator\\components\\com_gantry5\\templates\\ajax\\fontpicker.html.twig");
    }
}
