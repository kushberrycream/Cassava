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

/* @gantry-admin/modals/atom.html.twig */
class __TwigTemplate_035483d71a8ac34c5c228432937ccd31 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'gantry' => [$this, 'block_gantry'],
            'title' => [$this, 'block_title'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return $this->loadTemplate((((($context["ajax"] ?? null) - ($context["suffix"] ?? null))) ? ("@gantry-admin/partials/ajax.html.twig") : ("@gantry-admin/partials/base.html.twig")), "@gantry-admin/modals/atom.html.twig", 1);
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_gantry($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        echo "    <form method=\"post\"
          action=\"";
        // line 5
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "route", [0 => ($context["action"] ?? null)], "method", false, false, false, 5), "html", null, true);
        echo "\"
          data-g-inheritance-settings=\"";
        // line 6
        echo twig_escape_filter($this->env, json_encode(["id" => twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "id", [], "any", false, false, false, 6), "type" => "atom", "subtype" => twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "type", [], "any", false, false, false, 6)]), "html_attr");
        echo "\"
    >
        <input type=\"hidden\" name=\"id\" value=\"";
        // line 8
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "id", [], "any", false, false, false, 8), "html", null, true);
        echo "\" />
        <div class=\"g-tabs\" role=\"tablist\">
            <ul>
                ";
        // line 12
        echo "                <li class=\"active\">
                    <a href=\"#\" id=\"g-settings-atom-tab\" role=\"presentation\" aria-controls=\"g-settings-atom\" role=\"tab\" aria-expanded=\"true\">
                        ";
        // line 14
        if (($context["inheritable"] ?? null)) {
            echo "<i class=\"fa fa-fw fa-";
            echo (((twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "inherit", [], "any", false, false, false, 14) && twig_in_filter("attributes", twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "inherit", [], "any", false, false, false, 14), "include", [], "any", false, false, false, 14)))) ? ("lock") : ("unlock"));
            echo "\" aria-hidden=\"true\"></i>";
        }
        // line 15
        echo "                        ";
        $this->displayBlock('title', $context, $blocks);
        // line 18
        echo "                    </a>
                </li>
                ";
        // line 21
        echo "                ";
        if (($context["inheritance"] ?? null)) {
            // line 22
            echo "                    <li>
                        <a href=\"#\" id=\"g-settings-inheritance-tab\" role=\"presentation\" aria-controls=\"g-settings-inheritance\" aria-expanded=\"false\">
                            ";
            // line 24
            echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_INHERITANCE"), "html", null, true);
            echo "
                        </a>
                    </li>
                ";
        }
        // line 28
        echo "            </ul>
        </div>

        <div class=\"g-panes\">
            ";
        // line 33
        echo "            <div class=\"g-pane active\" role=\"tabpanel\" id=\"g-settings-atom\" aria-labelledby=\"g-settings-atom-tab\" aria-expanded=\"true\">
                ";
        // line 34
        $this->loadTemplate("@gantry-admin/pages/configurations/layouts/particle-card.html.twig", "@gantry-admin/modals/atom.html.twig", 34)->display(twig_array_merge($context, ["item" =>         // line 35
($context["item"] ?? null), "title" => twig_get_attribute($this->env, $this->source,         // line 36
($context["item"] ?? null), "title", [], "any", false, false, false, 36), "blueprints" => twig_get_attribute($this->env, $this->source,         // line 37
($context["blueprints"] ?? null), "form", [], "any", false, false, false, 37), "overrideable" => (        // line 38
($context["overrideable"] ?? null) && ( !twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["blueprints"] ?? null), "form", [], "any", false, true, false, 38), "overrideable", [], "any", true, true, false, 38) || twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["blueprints"] ?? null), "form", [], "any", false, false, false, 38), "overrideable", [], "any", false, false, false, 38))), "inherit" => (((twig_in_filter("attributes", twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source,         // line 39
($context["item"] ?? null), "inherit", [], "any", false, false, false, 39), "include", [], "any", false, false, false, 39)) && twig_in_filter(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "inherit", [], "any", false, false, false, 39), "outline", [], "any", false, false, false, 39), twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["inheritance"] ?? null), "form", [], "any", false, false, false, 39), "fields", [], "any", false, false, false, 39), "outline", [], "any", false, false, false, 39), "filter", [], "any", false, false, false, 39)))) ? (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "inherit", [], "any", false, false, false, 39), "outline", [], "any", false, false, false, 39)) : (null))]));
        // line 41
        echo "            </div>

            ";
        // line 44
        echo "            ";
        if (($context["inheritance"] ?? null)) {
            // line 45
            echo "                <div class=\"g-pane\" role=\"tabpanel\" id=\"g-settings-inheritance\" aria-labelledby=\"g-settings-inheritance-tab\" aria-expanded=\"false\">
                    <div class=\"card settings-block\">
                        <h4>
                            ";
            // line 48
            echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_INHERITANCE"), "html", null, true);
            echo "
                        </h4>
                        <div class=\"inner-params\">
                            ";
            // line 51
            $this->loadTemplate("forms/fields.html.twig", "@gantry-admin/modals/atom.html.twig", 51)->display(twig_to_array(["gantry" =>             // line 52
($context["gantry"] ?? null), "blueprints" => twig_get_attribute($this->env, $this->source,             // line 53
($context["inheritance"] ?? null), "form", [], "any", false, false, false, 53), "data" => ["inherit" => twig_get_attribute($this->env, $this->source,             // line 54
($context["item"] ?? null), "inherit", [], "any", false, false, false, 54)], "prefix" => "inherit."]));
            // line 57
            echo "                        </div>
                    </div>
                </div>
            ";
        }
        // line 61
        echo "        </div>

        <div class=\"g-modal-actions\">
            <button class=\"button button-primary\" type=\"submit\">";
        // line 64
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_APPLY"), "html", null, true);
        echo "</button>
            <button class=\"button button-primary\" data-apply-and-save=\"\">";
        // line 65
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_APPLY_SAVE"), "html", null, true);
        echo "</button>
            <button class=\"button g5-dialog-close\">";
        // line 66
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_CANCEL"), "html", null, true);
        echo "</button>
        </div>
    </form>
";
    }

    // line 15
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 16
        echo "                            ";
        echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->transFilter("GANTRY5_PLATFORM_ATOM"), "html", null, true);
        echo "
                        ";
    }

    public function getTemplateName()
    {
        return "@gantry-admin/modals/atom.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  169 => 16,  165 => 15,  157 => 66,  153 => 65,  149 => 64,  144 => 61,  138 => 57,  136 => 54,  135 => 53,  134 => 52,  133 => 51,  127 => 48,  122 => 45,  119 => 44,  115 => 41,  113 => 39,  112 => 38,  111 => 37,  110 => 36,  109 => 35,  108 => 34,  105 => 33,  99 => 28,  92 => 24,  88 => 22,  85 => 21,  81 => 18,  78 => 15,  72 => 14,  68 => 12,  62 => 8,  57 => 6,  53 => 5,  50 => 4,  46 => 3,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@gantry-admin/modals/atom.html.twig", "C:\\MAMP\\htdocs\\cassava.nri.org\\administrator\\components\\com_gantry5\\templates\\modals\\atom.html.twig");
    }
}
