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

/* @nucleus/page_head.html.twig */
class __TwigTemplate_bd95f6d04b47df98c269fbf7f439824d extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'head_stylesheets' => [$this, 'block_head_stylesheets'],
            'head_scripts' => [$this, 'block_head_scripts'],
            'head_platform' => [$this, 'block_head_platform'],
            'head_overrides' => [$this, 'block_head_overrides'],
            'head_title' => [$this, 'block_head_title'],
            'head_meta' => [$this, 'block_head_meta'],
            'head_application' => [$this, 'block_head_application'],
            'head_ie_stylesheets' => [$this, 'block_head_ie_stylesheets'],
            'head' => [$this, 'block_head'],
            'head_custom' => [$this, 'block_head_custom'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "debugger", [], "any", false, false, false, 1), "assets", [], "method", false, false, false, 1);
        // line 2
        twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "theme", [], "any", false, false, false, 2), "loadAtoms", [], "method", false, false, false, 2);
        // line 4
        $context["faEnabled"] = ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, true, false, 4), "page", [], "any", false, true, false, 4), "fontawesome", [], "any", false, true, false, 4), "enable", [], "any", true, true, false, 4)) ? (_twig_default_filter(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, true, false, 4), "page", [], "any", false, true, false, 4), "fontawesome", [], "any", false, true, false, 4), "enable", [], "any", false, false, false, 4), 1)) : (1));
        // line 5
        $context["faVersion"] = (((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, true, false, 5), "page", [], "any", false, true, false, 5), "fontawesome", [], "any", false, true, false, 5), "version", [], "any", true, true, false, 5) &&  !(null === twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, true, false, 5), "page", [], "any", false, true, false, 5), "fontawesome", [], "any", false, true, false, 5), "version", [], "any", false, false, false, 5)))) ? (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, true, false, 5), "page", [], "any", false, true, false, 5), "fontawesome", [], "any", false, true, false, 5), "version", [], "any", false, false, false, 5)) : ((((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, true, false, 5), "page", [], "any", false, true, false, 5), "fontawesome", [], "any", false, true, false, 5), "default_version", [], "any", true, true, false, 5) &&  !(null === twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, true, false, 5), "page", [], "any", false, true, false, 5), "fontawesome", [], "any", false, true, false, 5), "default_version", [], "any", false, false, false, 5)))) ? (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, true, false, 5), "page", [], "any", false, true, false, 5), "fontawesome", [], "any", false, true, false, 5), "default_version", [], "any", false, false, false, 5)) : ("fa4"))));
        // line 6
        $assetFunction = $this->env->getFunction('parse_assets')->getCallable();
        $assetVariables = ["priority" => 10];
        if ($assetVariables && !is_array($assetVariables)) {
            throw new UnexpectedValueException('{% scripts with x %}: x is not an array');
        }
        $location = "head";
        if ($location && !is_string($location)) {
            throw new UnexpectedValueException('{% scripts in x %}: x is not a string');
        }
        $priority = isset($assetVariables['priority']) ? $assetVariables['priority'] : 0;
        ob_start();
        // line 7
        echo "    ";
        $this->displayBlock('head_stylesheets', $context, $blocks);
        // line 14
        $this->displayBlock('head_scripts', $context, $blocks);
        // line 27
        $this->displayBlock('head_platform', $context, $blocks);
        // line 28
        echo "
    ";
        // line 29
        $this->displayBlock('head_overrides', $context, $blocks);
        $content = ob_get_clean();
        $assetFunction($content, $location, $priority);
        // line 50
        echo "<head>

    ";
        // line 52
        echo twig_join_filter(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "document", [], "any", false, false, false, 52), "getHtml", [0 => "head_top"], "method", false, false, false, 52), "
    ");
        // line 54
        $this->displayBlock('head_title', $context, $blocks);
        // line 57
        echo "
    ";
        // line 58
        $this->displayBlock('head_meta', $context, $blocks);
        // line 83
        echo "
    ";
        // line 84
        $this->displayBlock('head_application', $context, $blocks);
        // line 88
        echo "
    ";
        // line 89
        $this->displayBlock('head_ie_stylesheets', $context, $blocks);
        // line 92
        $this->displayBlock('head', $context, $blocks);
        // line 93
        $this->displayBlock('head_custom', $context, $blocks);
        // line 98
        echo twig_join_filter(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "document", [], "any", false, false, false, 98), "getHtml", [0 => "head_bottom"], "method", false, false, false, 98), "
    ");
        echo "
</head>
";
    }

    // line 7
    public function block_head_stylesheets($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 8
        echo "<link rel=\"stylesheet\" href=\"gantry-engine://css-compiled/nucleus.css\" type=\"text/css\"/>
        ";
        // line 9
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "theme", [], "any", false, true, false, 9), "configuration", [], "any", false, true, false, 9), "css", [], "any", false, true, false, 9), "persistent", [], "any", true, true, false, 9)) ? (_twig_default_filter(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "theme", [], "any", false, true, false, 9), "configuration", [], "any", false, true, false, 9), "css", [], "any", false, true, false, 9), "persistent", [], "any", false, false, false, 9), twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "theme", [], "any", false, false, false, 9), "configuration", [], "any", false, false, false, 9), "css", [], "any", false, false, false, 9), "files", [], "any", false, false, false, 9))) : (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "theme", [], "any", false, false, false, 9), "configuration", [], "any", false, false, false, 9), "css", [], "any", false, false, false, 9), "files", [], "any", false, false, false, 9))));
        foreach ($context['_seq'] as $context["_key"] => $context["scss"]) {
            // line 10
            echo "        <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, $context["scss"], "html", null, true);
            echo ".scss\" type=\"text/css\"/>";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['scss'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 12
        echo "    ";
    }

    // line 14
    public function block_head_scripts($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 15
        if (($context["faEnabled"] ?? null)) {
            // line 16
            echo "            ";
            if (((($context["faVersion"] ?? null) == "manual") || twig_trim_filter(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, false, false, 16), "page", [], "any", false, false, false, 16), "fontawesome", [], "any", false, false, false, 16), "html_js_import", [], "any", false, false, false, 16)))) {
                // line 17
                echo "                ";
                echo $this->extensions['Gantry\Component\Twig\TwigExtension']->htmlFilter(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, false, false, 17), "page", [], "any", false, false, false, 17), "fontawesome", [], "any", false, false, false, 17), "html_js_import", [], "any", false, false, false, 17));
            } elseif ((            // line 18
($context["faVersion"] ?? null) == "fa5js")) {
                // line 19
                echo "                <script type=\"text/javascript\" src=\"";
                echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->urlFunc("gantry-assets://js/font-awesome5-all.min.js"), "html", null, true);
                echo "\"></script>
                ";
                // line 20
                if (((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, true, false, 20), "page", [], "any", false, true, false, 20), "fontawesome", [], "any", false, true, false, 20), "fa4_compatibility", [], "any", true, true, false, 20)) ? (_twig_default_filter(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, true, false, 20), "page", [], "any", false, true, false, 20), "fontawesome", [], "any", false, true, false, 20), "fa4_compatibility", [], "any", false, false, false, 20), 1)) : (1))) {
                    // line 21
                    echo "                    <script type=\"text/javascript\" src=\"";
                    echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->urlFunc("gantry-assets://js/font-awesome5-shim.min.js"), "html", null, true);
                    echo "\"></script>
                ";
                }
                // line 23
                echo "            ";
            }
            // line 24
            echo "        ";
        }
        // line 25
        echo "    ";
    }

    // line 27
    public function block_head_platform($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    // line 29
    public function block_head_overrides($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 30
        if (($context["faEnabled"] ?? null)) {
            // line 31
            echo "            ";
            if (((($context["faVersion"] ?? null) == "manual") || twig_trim_filter(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, false, false, 31), "page", [], "any", false, false, false, 31), "fontawesome", [], "any", false, false, false, 31), "html_css_import", [], "any", false, false, false, 31)))) {
                // line 32
                echo "                ";
                echo $this->extensions['Gantry\Component\Twig\TwigExtension']->htmlFilter(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, false, false, 32), "page", [], "any", false, false, false, 32), "fontawesome", [], "any", false, false, false, 32), "html_css_import", [], "any", false, false, false, 32));
            } elseif ((            // line 33
($context["faVersion"] ?? null) == "fa4")) {
                // line 34
                echo "                <link rel=\"stylesheet\" href=\"gantry-assets://css/font-awesome.min.css\" type=\"text/css\"/>
            ";
            } elseif ((            // line 35
($context["faVersion"] ?? null) == "fa5css")) {
                // line 36
                echo "                <link rel=\"stylesheet\" href=\"gantry-assets://css/font-awesome5-all.min.css\" type=\"text/css\">
                ";
                // line 37
                if (((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, true, false, 37), "page", [], "any", false, true, false, 37), "fontawesome", [], "any", false, true, false, 37), "fa4_compatibility", [], "any", true, true, false, 37)) ? (_twig_default_filter(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, true, false, 37), "page", [], "any", false, true, false, 37), "fontawesome", [], "any", false, true, false, 37), "fa4_compatibility", [], "any", false, false, false, 37), 1)) : (1))) {
                    // line 38
                    echo "                    <link rel=\"stylesheet\" href=\"gantry-assets://css/font-awesome5-shim.min.css\" type=\"text/css\">
                ";
                }
                // line 40
                echo "            ";
            } elseif ((((($context["faVersion"] ?? null) == "fa5js") || ((($context["faVersion"] ?? null) == "manual") && twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, false, false, 40), "page", [], "any", false, false, false, 40), "fontawesome", [], "any", false, false, false, 40), "html_js_import", [], "any", false, false, false, 40))) && ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, true, false, 40), "page", [], "any", false, true, false, 40), "fontawesome", [], "any", false, true, false, 40), "content_compatibility", [], "any", true, true, false, 40)) ? (_twig_default_filter(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, true, false, 40), "page", [], "any", false, true, false, 40), "fontawesome", [], "any", false, true, false, 40), "content_compatibility", [], "any", false, false, false, 40), 1)) : (1)))) {
                // line 41
                echo "                <link rel=\"stylesheet\" href=\"gantry-assets://css/font-awesome5-pseudo.min.css\" type=\"text/css\">
            ";
            }
            // line 43
            echo "        ";
        }
        // line 44
        echo "        ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "theme", [], "any", false, false, false, 44), "configuration", [], "any", false, false, false, 44), "css", [], "any", false, false, false, 44), "overrides", [], "any", false, false, false, 44));
        foreach ($context['_seq'] as $context["_key"] => $context["scss"]) {
            // line 45
            echo "        <link rel=\"stylesheet\" href=\"";
            echo twig_escape_filter($this->env, $context["scss"], "html", null, true);
            echo ".scss\" type=\"text/css\"/>";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['scss'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 47
        echo "    ";
    }

    // line 54
    public function block_head_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 55
        echo "<title>Title</title>";
    }

    // line 58
    public function block_head_meta($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 59
        echo "        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\" />
        ";
        // line 61
        if (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, false, false, 61), "page", [], "any", false, false, false, 61), "head", [], "any", false, false, false, 61), "meta", [], "any", false, false, false, 61)) {
            // line 62
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, false, false, 62), "page", [], "any", false, false, false, 62), "head", [], "any", false, false, false, 62), "meta", [], "any", false, false, false, 62));
            foreach ($context['_seq'] as $context["_key"] => $context["attributes"]) {
                // line 63
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($context["attributes"]);
                foreach ($context['_seq'] as $context["key"] => $context["value"]) {
                    // line 64
                    echo "                    ";
                    if ((is_string($__internal_compile_0 = $context["key"]) && is_string($__internal_compile_1 = "og:") && ('' === $__internal_compile_1 || 0 === strpos($__internal_compile_0, $__internal_compile_1)))) {
                        // line 65
                        echo "                    <meta property=\"";
                        echo twig_escape_filter($this->env, $context["key"]);
                        echo "\" content=\"";
                        echo twig_escape_filter($this->env, $context["value"]);
                        echo "\" />
                    ";
                    } else {
                        // line 67
                        echo "                    <meta name=\"";
                        echo twig_escape_filter($this->env, $context["key"]);
                        echo "\" content=\"";
                        echo twig_escape_filter($this->env, $context["value"]);
                        echo "\" />
                    ";
                    }
                    // line 69
                    echo "                ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['key'], $context['value'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['attributes'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 72
        echo twig_join_filter(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "document", [], "any", false, false, false, 72), "getHtml", [0 => "head_meta"], "method", false, false, false, 72), "
    ");
        echo "

        ";
        // line 74
        if (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, false, false, 74), "page", [], "any", false, false, false, 74), "assets", [], "any", false, false, false, 74), "favicon", [], "any", false, false, false, 74)) {
            // line 75
            echo "        <link rel=\"icon\" type=\"image/x-icon\" href=\"";
            echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->urlFunc(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, false, false, 75), "page", [], "any", false, false, false, 75), "assets", [], "any", false, false, false, 75), "favicon", [], "any", false, false, false, 75)), "html", null, true);
            echo "\" />
        ";
        }
        // line 77
        echo "
        ";
        // line 78
        if (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, false, false, 78), "page", [], "any", false, false, false, 78), "assets", [], "any", false, false, false, 78), "touchicon", [], "any", false, false, false, 78)) {
            // line 79
            echo "        <link rel=\"apple-touch-icon\" sizes=\"180x180\" href=\"";
            echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->urlFunc(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, false, false, 79), "page", [], "any", false, false, false, 79), "assets", [], "any", false, false, false, 79), "touchicon", [], "any", false, false, false, 79)), "html", null, true);
            echo "\">
        <link rel=\"icon\" sizes=\"192x192\" href=\"";
            // line 80
            echo twig_escape_filter($this->env, $this->extensions['Gantry\Component\Twig\TwigExtension']->urlFunc(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, false, false, 80), "page", [], "any", false, false, false, 80), "assets", [], "any", false, false, false, 80), "touchicon", [], "any", false, false, false, 80)), "html", null, true);
            echo "\">
        ";
        }
        // line 82
        echo "    ";
    }

    // line 84
    public function block_head_application($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 85
        echo twig_join_filter(twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "styles", [0 => "head"], "method", false, false, false, 85), "
");
        echo "
        ";
        // line 86
        echo twig_join_filter(twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "scripts", [0 => "head"], "method", false, false, false, 86), "
");
    }

    // line 89
    public function block_head_ie_stylesheets($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    // line 92
    public function block_head($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    // line 93
    public function block_head_custom($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 94
        echo "        ";
        if (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, false, false, 94), "page", [], "any", false, false, false, 94), "head", [], "any", false, false, false, 94), "head_bottom", [], "any", false, false, false, 94)) {
            // line 95
            echo "        ";
            echo twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["gantry"] ?? null), "config", [], "any", false, false, false, 95), "page", [], "any", false, false, false, 95), "head", [], "any", false, false, false, 95), "head_bottom", [], "any", false, false, false, 95);
            echo "
        ";
        }
        // line 97
        echo "    ";
    }

    public function getTemplateName()
    {
        return "@nucleus/page_head.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  366 => 97,  360 => 95,  357 => 94,  353 => 93,  347 => 92,  341 => 89,  336 => 86,  331 => 85,  327 => 84,  323 => 82,  318 => 80,  313 => 79,  311 => 78,  308 => 77,  302 => 75,  300 => 74,  294 => 72,  283 => 69,  275 => 67,  267 => 65,  264 => 64,  260 => 63,  256 => 62,  254 => 61,  250 => 59,  246 => 58,  242 => 55,  238 => 54,  234 => 47,  226 => 45,  221 => 44,  218 => 43,  214 => 41,  211 => 40,  207 => 38,  205 => 37,  202 => 36,  200 => 35,  197 => 34,  195 => 33,  192 => 32,  189 => 31,  187 => 30,  183 => 29,  177 => 27,  173 => 25,  170 => 24,  167 => 23,  161 => 21,  159 => 20,  154 => 19,  152 => 18,  149 => 17,  146 => 16,  144 => 15,  140 => 14,  136 => 12,  128 => 10,  124 => 9,  121 => 8,  117 => 7,  109 => 98,  107 => 93,  105 => 92,  103 => 89,  100 => 88,  98 => 84,  95 => 83,  93 => 58,  90 => 57,  88 => 54,  85 => 52,  81 => 50,  77 => 29,  74 => 28,  72 => 27,  70 => 14,  67 => 7,  55 => 6,  53 => 5,  51 => 4,  49 => 2,  47 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@nucleus/page_head.html.twig", "C:\\MAMP\\htdocs\\cassava.nri.org\\media\\gantry5\\engines\\nucleus\\templates\\page_head.html.twig");
    }
}
