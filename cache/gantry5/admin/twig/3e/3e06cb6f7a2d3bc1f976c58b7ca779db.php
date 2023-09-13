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

/* @gantry-admin/layouts/switcher.html.twig */
class __TwigTemplate_3f33323a70ede1bdb5a0bdff037b6175 extends \Twig\Template
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
        echo "
<div class=\"g-tabs\" role=\"tablist\">
    <ul>
        <li class=\"active\">
            <a href=\"#\" id=\"g-switcher-platforms-tab\" role=\"presentation\" aria-controls=\"g-switcher-platforms\" role=\"tab\" aria-expanded=\"true\">
                ";
        // line 6
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_PRESETS"), "html", null, true);
        echo "
            </a>
        </li>
        <li>
            <a href=\"#\" id=\"g-switcher-platforms-outlines\" role=\"presentation\" aria-controls=\"g-switcher-outlines\" role=\"tab\" aria-expanded=\"false\">
                ";
        // line 11
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_OUTLINES"), "html", null, true);
        echo "
            </a>
        </li>
    </ul>
</div>

<div class=\"g-panes\">
    <div class=\"g-pane clearfix active\" role=\"tabpanel\" id=\"g-switcher-platforms\" aria-labelledby=\"g-switcher-platforms-tab\" aria-expanded=\"true\">
        <div class=\"g-preserve-particles\">
            <label>
                <input data-g-preserve=\"preset\" type=\"checkbox\" checked=\"checked\" />
                ";
        // line 22
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_SWITCH_PRESET_DESC"), "html", null, true);
        echo "
            </label>
        </div>

        ";
        // line 26
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["presets"] ?? null));
        foreach ($context['_seq'] as $context["name"] => $context["group"]) {
            // line 27
            echo "        <ul class=\"g-switch-presets";
            if (($context["name"] == "user")) {
                echo " float-left";
            } else {
                echo " float-right";
            }
            echo "\" role=\"tablist\">
            <li tabindex=\"0\" class=\"g-switch-title\" role=\"presentation\">
                ";
            // line 29
            echo twig_escape_filter($this->env, ((($context["name"] == "user")) ? ($this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_LM_SWITCHER_USER")) : ($this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_LM_SWITCHER_PLATFORM"))), "html", null, true);
            echo "
            </li>
            ";
            // line 31
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($context["group"]);
            foreach ($context['_seq'] as $context["key"] => $context["current"]) {
                // line 32
                echo "            <li tabindex=\"0\" aria-label=\"";
                echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_X_PRESET", $context["current"]), "html", null, true);
                echo "\" role=\"button\"
                data-switch=\"";
                // line 33
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "route", [0 => ((("configurations/" . ($context["configuration"] ?? null)) . "/layout/preset/") . $context["key"])], "method", false, false, false, 33), "html", null, true);
                echo "\"
                class=\"g-switch-preset\"
            >
                ";
                // line 36
                echo twig_escape_filter($this->env, $context["current"], "html", null, true);
                echo "
            </li>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['key'], $context['current'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 39
            echo "        </ul>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['name'], $context['group'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 41
        echo "    </div>

    <div class=\"g-pane clearfix\" role=\"tabpanel\" id=\"g-switcher-outlines\" aria-labelledby=\"g-switcher-outlines-tab\" aria-expanded=\"false\">
        ";
        // line 44
        $context["user_conf"] = twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "outlines", [], "any", false, false, false, 44), "copy", [], "any", false, false, false, 44), "user", [], "any", false, false, false, 44);
        // line 45
        echo "        ";
        $context["system_conf"] = twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "outlines", [], "any", false, false, false, 45), "system", [], "any", false, false, false, 45);
        // line 46
        echo "
        <div class=\"g-preserve-particles\">
            <label>
                <input data-g-preserve=\"outline\" type=\"checkbox\" />
                ";
        // line 50
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_SWITCH_OUTLINE_DESC"), "html", null, true);
        echo "
            </label>
            ";
        // line 52
        if ((($context["configuration"] ?? null) != "default")) {
            // line 53
            echo "            <label>
                <input data-g-inherit=\"outline\" type=\"checkbox\" checked=\"checked\" />
                ";
            // line 55
            echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_SWITCH_OUTLINE_INHERIT_DESC"), "html", null, true);
            echo "
            </label>
            ";
        }
        // line 58
        echo "        </div>
        <ul class=\"g-switch-conf-user";
        // line 59
        if (twig_get_attribute($this->env, $this->source, ($context["system_conf"] ?? null), "count", [], "any", false, false, false, 59)) {
            echo " float-left";
        }
        echo "\" role=\"tablist\">
            <li tabindex=\"0\" class=\"g-switch-title\" role=\"presentation\">";
        // line 60
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_LM_SWITCHER_USER"), "html", null, true);
        echo "</li>
            <li tabindex=\"0\"
                aria-label=\"";
        // line 62
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_X_OUTLINE", $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_BASE_OUTLINE")), "html", null, true);
        echo "\"
                role=\"button\"
                data-switch=\"";
        // line 64
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "route", [0 => (("configurations/" . ($context["configuration"] ?? null)) . "/layout/switch/default")], "method", false, false, false, 64), "html", null, true);
        echo "\"
                class=\"g-switch-configuration\"
            >
                ";
        // line 67
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_BASE_OUTLINE"), "html", null, true);
        echo "
            </li>
            ";
        // line 69
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["user_conf"] ?? null));
        foreach ($context['_seq'] as $context["key"] => $context["current"]) {
            // line 70
            echo "                ";
            if (($context["key"] != ($context["configuration"] ?? null))) {
                // line 71
                echo "                    ";
                $context["label"] = twig_title_string_filter($this->env, twig_trim_filter(twig_replace_filter($context["current"], ["_" => " "])));
                // line 72
                echo "                    <li tabindex=\"0\"
                        aria-label=\"";
                // line 73
                echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_X_OUTLINE", ($context["label"] ?? null)), "html", null, true);
                echo "\"
                        role=\"button\"
                        data-switch=\"";
                // line 75
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "route", [0 => ((("configurations/" . ($context["configuration"] ?? null)) . "/layout/switch/") . $context["key"])], "method", false, false, false, 75), "html", null, true);
                echo "\"
                        class=\"g-switch-configuration\"
                    >
                        ";
                // line 78
                echo twig_escape_filter($this->env, ($context["label"] ?? null), "html", null, true);
                echo "
                    </li>
                ";
            }
            // line 81
            echo "            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['current'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 82
        echo "        </ul>

        ";
        // line 84
        if (twig_get_attribute($this->env, $this->source, ($context["system_conf"] ?? null), "count", [], "any", false, false, false, 84)) {
            // line 85
            echo "            <ul class=\"g-switch-conf-systems float-right\">
                <li tabindex=\"0\" class=\"g-switch-title\" role=\"presentation\">";
            // line 86
            echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_LM_SWITCHER_SYSTEM"), "html", null, true);
            echo "</li>
                ";
            // line 87
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["system_conf"] ?? null));
            foreach ($context['_seq'] as $context["key"] => $context["current"]) {
                // line 88
                echo "                    ";
                $context["label"] = twig_escape_filter($this->env, twig_capitalize_string_filter($this->env, twig_trim_filter(twig_replace_filter($context["current"], ["_" => " "]))));
                // line 89
                echo "                    <li tabindex=\"0\"
                        aria-label=\"";
                // line 90
                echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_X_OUTLINE", ($context["label"] ?? null)), "html", null, true);
                echo "\"
                        role=\"button\"
                        data-switch=\"";
                // line 92
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "route", [0 => ((("configurations/" . ($context["configuration"] ?? null)) . "/layout/switch/") . $context["key"])], "method", false, false, false, 92), "html", null, true);
                echo "\"
                        class=\"g-switch-configuration\"
                    >
                        ";
                // line 95
                echo twig_escape_filter($this->env, ($context["label"] ?? null), "html", null, true);
                echo "
                    </li>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['key'], $context['current'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 98
            echo "            </ul>
        ";
        }
        // line 100
        echo "    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "@gantry-admin/layouts/switcher.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  269 => 100,  265 => 98,  256 => 95,  250 => 92,  245 => 90,  242 => 89,  239 => 88,  235 => 87,  231 => 86,  228 => 85,  226 => 84,  222 => 82,  216 => 81,  210 => 78,  204 => 75,  199 => 73,  196 => 72,  193 => 71,  190 => 70,  186 => 69,  181 => 67,  175 => 64,  170 => 62,  165 => 60,  159 => 59,  156 => 58,  150 => 55,  146 => 53,  144 => 52,  139 => 50,  133 => 46,  130 => 45,  128 => 44,  123 => 41,  116 => 39,  107 => 36,  101 => 33,  96 => 32,  92 => 31,  87 => 29,  77 => 27,  73 => 26,  66 => 22,  52 => 11,  44 => 6,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@gantry-admin/layouts/switcher.html.twig", "C:\\MAMP\\htdocs\\cassava.nri.org\\administrator\\components\\com_gantry5\\templates\\layouts\\switcher.html.twig");
    }
}
